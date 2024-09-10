<?php

namespace backend\controllers;

use Yii;
use backend\models\Organization;
use backend\models\OrganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Unit;
use backend\models\OrganizationCabinet;
use backend\models\Memberorganization;
use yii\helpers\ArrayHelper;
use yii\base\Object;
use backend\models\Cabinetboxmodel;

/**
 * OrganizationController implements the CRUD actions for Organization model.
 */
class OrganizationController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function  behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all of Organization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organization model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organization();
        $model->box_models = Cabinetboxmodel::find()->where(['is_allocable'=>1])->all();
        $this->decodeChargeRule($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->charge_rule = $this->encodeChargeRules($model->sign_up_fee,$model->sign_fee_pay_online,$model->monthly_fee,$model->month_fee_pay_online,$model->box_penalty);
            $model->save();
            //return $this->redirect(['view', 'id' => $model->organization_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->box_models = Cabinetboxmodel::find()->where(['is_allocable'=>1])->asArray()->all();
        $this->decodeChargeRule($model);
        if ($model->load(Yii::$app->request->post())) {  
            $model->charge_rule = $this->encodeChargeRules($model->sign_up_fee,$model->sign_fee_pay_online,$model->monthly_fee,$model->month_fee_pay_online,$model->box_penalty);//var_dump($model->charge_rule);exit;
            $model->save();
            //return $this->redirect(['view', 'id' => $model->organization_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    protected  function  encodeChargeRules($sign_up_fee,$sign_fee_pay_online,$monthly_fee,$month_fee_pay_online, $box_penalty)
    {
        //{"signup_fee":{"amount":0,"pay_online":0},"monthly_fee":{"amount":0,"pay_online":1}}
        /*
        {
            "signup_fee": {
            "amount": "50",
            "pay_online": "1"
            },
            "box_penalty": {
            "10001": {
            "amount": "5",
            "pay_online": "1",
            "grace_day": 2
            },
            "10002": {
            "amount": "1.5",
            "pay_online": "1",
            "grace_day": 1
            },
            "10003": {
            "amount": "2",
            "pay_online": "1",
            "grace_day": 1
            }
            },
            "monthly_fee": {
            "amount": "12",
            "pay_online": "1"
            }
        }*/
        $charge_rules = array(
            "signup_fee" => array("amount" => $sign_up_fee,"pay_online"=> $sign_fee_pay_online),
            "monthly_fee" => array("amount" => $monthly_fee,"pay_online"=> $month_fee_pay_online),
            "box_penalty"=>$box_penalty,
        );
        if(empty($box_penalty))
        {
            unset($charge_rules['box_penalty']);
        }
        return json_encode($charge_rules);
    }
    protected function decodeChargeRule($model)
    {
        $charge_rules = [];
        if(empty($model->charge_rule))
        {
            $box_penalty = array();
            foreach ($model->box_models as $key=>$value)
            {
                $box_penalty[$value['model_id']] = ["amount"=>"0","pay_online"=> "1","grace_day"=> 1];
            }
            $charge_rule = array(
                "signup_fee" => array("amount" => 0,"pay_online"=> 0),
                "monthly_fee" => array("amount" => 0,"pay_online"=> 1),
                "box_penalty"=>$box_penalty,
            );
            $model->charge_rule = json_encode($charge_rule); // var_dump( $model->charge_rule);exit;
        }
        $charge_rules = json_decode($model->charge_rule); //var_dump($charge_rules);exit;
        $model->sign_up_fee = $charge_rules->signup_fee->amount;
        $model->sign_fee_pay_online = $charge_rules->signup_fee->pay_online;
        $model->monthly_fee = $charge_rules->monthly_fee->amount;
        $model->month_fee_pay_online = $charge_rules->monthly_fee->pay_online;
        if(empty($charge_rules->box_penalty))
        {
            $charge_rules->box_penalty = array();
        }
        $box_penalty_count = count($charge_rules->box_penalty);
        if(count($model->box_models)!=$box_penalty_count) 
        { 
            $new_box_penalty = array();
            foreach ($model->box_models as $key=>$value)
            { //var_dump(isset($charge_rules->box_penalty->$value['model_id']->grace_day));exit;
                $new_box_penalty[$value['model_id']] = ["amount"=> $box_penalty_count == 0 ?"0": (isset($charge_rules->box_penalty->$value['model_id']->amount)?($charge_rules->box_penalty->$value['model_id']->amount):"0"),"pay_online"=> ($box_penalty_count == 0 ? "1":(isset($charge_rules->box_penalty->$value['model_id']->pay_online)?$charge_rules->box_penalty->$value['model_id']->pay_online:"1")),"grace_day"=> ($box_penalty_count == 0? 1: (isset($charge_rules->box_penalty->$value['model_id']->grace_day)?$charge_rules->box_penalty->$value['model_id']->grace_day:1))];
            }
            $charge_rules->box_penalty = json_decode(json_encode($new_box_penalty));  //var_dump($charge_rules->box_penalty);exit;
        }
        
        $model->box_penalty = empty($charge_rules->box_penalty) ? null:$charge_rules->box_penalty;
    }
    /**
     * Deletes an existing Organization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id=0)
    {
        if (Yii::$app->request->isAjax) 
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $id= explode(":", $data['id']);
            $id= $id[0];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
        $model = $this->findModel($id);
        if(Unit::find()->where(['organization_id'=>$model->organization_id])->count()>0)
        {
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'You should delete the organization unit data first.',
                    'code' => 100,
                ];
            }
            else 
            {
                \Yii::$app->getSession()->setFlash('error', 'You should delete the organization unit data first.');
                return $this->redirect(['index']);
            }
        }
        if(OrganizationCabinet::find()->where(['organization_id'=>$model->organization_id])->count()>0)
        {
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'You should delete the organization-locker bind relation first.',
                    'code' => 100,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('error', 'You should delete the organization-locker bind relation first.');
                return $this->redirect(['index']);
            }
        }
        if(Memberorganization::find()->where(['organization_id'=>$model->organization_id])->count()>0)
        {
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'There is a member already bind this organization.',
                    'code' => 100,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('error', 'There is a member already bind this organization.');
                return $this->redirect(['index']);
            }
        }
        $model->delete();
        if(Yii::$app->request->isAjax)
        {
            return [
                'msg' => 'Delete organization success.',
                'code' => 200,
            ];
        }
        else
        {
           \Yii::$app->getSession()->setFlash('success', 'Delete organization success.');
           return $this->redirect(['index']);
        }
        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Organization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use Yii;
use backend\models\Memberorganization;
use backend\models\MemberorganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Store;
use backend\models\Member;
use backend\components\Helper;

/**
 * MemberorganizationController implements the CRUD actions for Memberorganization model.
 */
class MemberorganizationController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
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
     * Lists all Memberorganization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberorganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Memberorganization model.
     * @param integer $member_id
     * @param integer $organization_id
     * @param integer $cancel_time
     * @return mixed
     */
    public function actionView($member_id, $organization_id, $cancel_time)
    {
        return $this->render('view', [
            'model' => $this->findModel($member_id, $organization_id, $cancel_time),
        ]);
    }

    /**
     * Creates a new Memberorganization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $member = Member::findOne(['member_id'=>$id]);
        $model = new Memberorganization();
        $organizations = Helper::getOrganizations();
        try 
        {
            if (Yii::$app->request->post())
            {
                $post = Yii::$app->request->post();
                $model->member_id = $post['Memberorganization']['member_id'];
                $model->organization_id = $post['Memberorganization']['organization_id'];
                $model->unit_id = isset($post['Memberorganization']['unit_id'])?$post['Memberorganization']['unit_id']:null;
                $model->cost_offline = $post['Memberorganization']['cost_offline'];
                $model->apply_time = time();
                $model->create_time = time();
                if(empty($model->unit_id))
                {
                    $model->addError('unit_id','Unit can not be empty, please select the unit.');
                    return $this->render('create', [
                        'model' => $model,
                        'member'=>$member,
                        'organizations'=>$organizations,
                    ]);
                }
                if(Memberorganization::find()->where(['member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'unit_id'=>$model->unit_id])->count()>0)
                {
                    $model->addError('unit_id','This user already bind this unit.');
                    return $this->render('create', [
                        'model' => $model,
                        'member'=>$member,
                        'organizations'=>$organizations,
                    ]);
                }
                $model->save();
                return $this->redirect(['apmrmember/index', 'MemberorganizationSearch[member_id]' => $model->member_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'member'=>$member,
                    'organizations'=>$organizations,
                ]);
            }
        }
        catch (\Exception $e)
        {
            $msg = $e->getMessage();
            $model->addError('unit_id',(stristr($msg,'duplicate entry'))?"You already bind another unit in this organization.":$e->getMessage());
            return $this->render('create', [
                'model' => $model,
                'member'=>$member,
                'organizations'=>$organizations,
            ]);
        }
    }
    public function actionApprove($member_id, $organization_id, $cancel_time)
    {
       $model = $this->findModel($member_id, $organization_id, $cancel_time);
        //approved-->cancel
        if($model->approve_status==1)
        {
            //cancel-->recover
            if($model->status ==3)
            {
                $model->status = 1;
                $model->cancel_time = 0;
                $model->approve_time = time();
            }
            else 
            {
                //approved-->cancel
                $count = Store::find()->leftJoin('o_organization_cabinet','o_organization_cabinet.cabinet_id = o_store.cabinet_id')->where(['to_member_id'=>$member_id,'pick_time'=>null,'pick_with'=>null])->andWhere(['in','organization_id',$organization_id])->count();
                //var_dump($count);exit;
                if($count>0)
                {
                    \Yii::$app->getSession()->setFlash('error', 'This member has unpicked packages, please pick the package up first.');
                    return $this->redirect(['index']);
                }
                $model->status = 3;
                $model->cancel_time = time();
            }
        }
        else if($model->approve_status==0)
        {
            $model->approve_status = 1;
            $model->status = 1;
            $model->approve_time = time();
        }
        $model->save();
        return $this->redirect(['index']);
    }
    /**
     * Updates an existing Memberorganization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $member_id
     * @param integer $organization_id
     * @param integer $cancel_time
     * @return mixed
     */
    public function actionUpdate($member_id, $organization_id, $cancel_time)
    {
        $model = $this->findModel($member_id, $organization_id, $cancel_time);;
        if (Yii::$app->request->post()) 
        {
            $post = Yii::$app->request->post();
            $unit_id = $post['Unit']['unit_id'];
            $cost_offline = $post['Memberorganization']['cost_offline'];
            $model->unit_id = $unit_id;
            $model->cost_offline = $cost_offline;
            if(Memberorganization::find()->where(['member_id'=>$member_id,'organization_id'=>$model->organization_id,'unit_id'=>$model->unit_id])->andWhere(['<>','create_time',$model->create_time])->count()>0)
            {
                \Yii::$app->getSession()->setFlash('error', 'This user already bind this unit.');
                return $this->render('update', [
                'model' => $model,
                ]);
            }
            else 
            {
                $model->save();
                return $this->redirect(['index']);
            }
           //return $this->redirect(['view', 'member_id' => $model->member_id, 'organization_id' => $model->organization_id, 'cancel_time' => $model->cancel_time]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Memberorganization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $member_id
     * @param integer $organization_id
     * @param integer $cancel_time
     * @return mixed
     */
    public function actionDelete($member_id, $organization_id, $cancel_time)
    {
        //$this->findModel($member_id, $organization_id, $cancel_time)->delete();
        $model = $this->findModel($member_id, $organization_id, $cancel_time);
        $model->status=3;
        $model->cancel_time = time();
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Memberorganization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $member_id
     * @param integer $organization_id
     * @param integer $cancel_time
     * @return Memberorganization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($member_id, $organization_id, $cancel_time)
    {
        if (($model = Memberorganization::findOne(['member_id' => $member_id, 'organization_id' => $organization_id, 'cancel_time' => $cancel_time])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

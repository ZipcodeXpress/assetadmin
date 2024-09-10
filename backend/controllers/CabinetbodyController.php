<?php

namespace backend\controllers;

use Yii;
use backend\models\Cabinetbody;
use backend\models\CabinetbodySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Cabinetbodybox;
use backend\models\Cabinetbox;
use backend\models\Cabinet;
use backend\models\Store;
use backend\models\Zdeliver;
use backend\models\ZTStoreOrders;

/**
 * CabinetbodyController implements the CRUD actions for Cabinetbody model.
 */
class CabinetbodyController extends CommonController
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
     * Lists all Cabinetbody models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CabinetbodySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cabinetbody model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cabinetbody model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cabinetbody();
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            //save body
            if ($model->load(Yii::$app->request->post())&& $model->save())
            {
                //check cabinet
                if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->count()>0)
                {
                    //create box
                    $this->createBox($model);
                    //以上执行都成功，则对数据库进行实际执行
                    $transaction->commit();
                    return $this->redirect(['index']);
                }
                else 
                {
                    $model->addError('cabinet_id','Invalid Locker ID');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
            else 
            {
                $model->addError('Save body failed！');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        catch (\Exception $e)
        {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            $model->addError('Save body failed！');
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    protected function createBox($body)
    {
        try 
        {
            $box_arr = [];
            $body_box_list = Cabinetbodybox::find()->where(['body_model_id'=>$body->body_model_id])->all();
            foreach ($body_box_list as $body_box_key=>$body_box)
            {
                $exist_acount = Cabinetbox::find()->where(['cabinet_id'=>$body->cabinet_id,'box_model_id'=> $body_box['box_model_id'],'body_id' => $body->body_id])->count();
                if($exist_acount>0)
                {
                    continue;
                }
                $box_arr[] = [
                    'box_model_id' => $body_box['box_model_id'],
                    'cabinet_id' => $body->cabinet_id,
                    'body_id' => $body->body_id,
                    'row' => $body_box['row'],
                    'column' => $body_box['column'],
                    'addr' => $body_box['addr'],
                    'create_time'=>time(),
                ];
            }
            
            $boxmodel = new Cabinetbox();
            foreach($box_arr as $attributes){
                $_model=clone $boxmodel;
                $_model->setAttributes($attributes);
                $_model->save();
            }
        }
        catch (\Exception $e)
        {
            $body->addError('Create box failed！');
            return $this->render('create', [
                'model' => $body,
            ]);
        }
    }
    /**
     * Updates an existing Cabinetbody model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->body_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cabinetbody model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id=0)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            if (Yii::$app->request->isAjax)
            {
                $data = Yii::$app->request->post(); //var_dump($data);
                $id= explode(":", $data['id']);
                $id= $id[0];
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            }
            $model = $this->findModel($id);
            //check orders
            $box_list = Cabinetbox::find()->where(['body_id'=>$model->body_id])->all();
            foreach ($box_list as $box)
            {
                $service_type = Cabinet::findOne(['cabinet_id'=>$box['cabinet_id']])->service_type;
                switch($service_type)
                {
                    case 'zippora':
                        if(Store::find()->where(['box_id'=>$box['box_id']])->andWhere(['pick_time'=> null,'pick_with'=> null])->count()>0)
                        {
                            if(Yii::$app->request->isAjax)
                            {
                                return [
                                    'msg' => 'There are some unfinished orders in this Locker Body.',
                                    'code' => 100,
                                ];
                            }
                            else
                            {
                                \Yii::$app->getSession()->setFlash('error', 'There are some unfinished orders in this Locker Body.');
                                return $this->redirect(['index']);
                            }
                        }
                        break;
                    case 'store':
                        if(ZTStoreOrders::find()->where(['box_id'=>$box['box_id']])->andWhere(['pick_time'=> null,'pick_with'=> null])->count()>0)
                        {
                            if(Yii::$app->request->isAjax)
                            {
                                return [
                                    'msg' => 'There are some unfinished orders in this Locker Body.',
                                    'code' => 100,
                                ];
                            }
                            else
                            {
                                \Yii::$app->getSession()->setFlash('error', 'There are some unfinished orders in this Locker Body.');
                                return $this->redirect(['index']);
                            }
                        }
                        break;
                    case 'ziplocker':
                        if(Zdeliver::find()->where(['from_box_id'=>$box['box_id'],'pick_time'=> null])->count()>0 || Zdeliver::find()->where(['to_box_id'=>$box['box_id'],'pick_time'=> null])->count()>0)
                        {
                            if(Yii::$app->request->isAjax)
                            {
                                return [
                                    'msg' => 'There are some unfinished orders in this Locker Body.',
                                    'code' => 100,
                                ];
                            }
                            else
                            {
                                \Yii::$app->getSession()->setFlash('error', 'There are some unfinished orders in this Locker Body.');
                                return $this->redirect(['index']);
                            }
                        }
                        break;
                }
            }
            Cabinetbox::deleteAll(['body_id' => $model->body_id]);
            if($model->delete())
            {
                //以上执行都成功，则对数据库进行实际执行
                $transaction->commit();
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'Delete Body and Boxes success.',
                        'code' => 200,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('success', 'Delete Body and Boxes success.');
                }
            }
            else 
            {
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'Delete action failed！',
                        'code' => 200,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('error', 'Delete action failed！');
                }
            }
            return $this->redirect(['index']);
        }
        catch (\Exception $e){
            $transaction->rollBack();
            $msg = $e->getMessage();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => $msg,
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('error', $msg);
            }
        }
    }

    /**
     * Finds the Cabinetbody model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cabinetbody the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cabinetbody::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

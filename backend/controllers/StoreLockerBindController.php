<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Cabinet;
use backend\models\Store;
use backend\models\StoreLockerBindModelSearch;
use backend\models\StoreLockerBindModel;
use backend\models\ZTStoreOrders;

/**
 * OrganizationCabinetController implements the CRUD actions for OrganizationCabinet model.
 */
class StoreLockerBindController extends CommonController
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
     * Lists all OrganizationCabinet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreLockerBindModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrganizationCabinet model.
     * @param integer $cabinet_id
     * @return mixed
     */
    public function actionView($oc_store_id, $cabinet_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($oc_store_id, $cabinet_id),
        ]);
    }

    /**
     * Creates a new OrganizationCabinet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StoreLockerBindModel();
        
        if ($model->load(Yii::$app->request->post())) {
            if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->count()==0)
            {
                $model->addError('cabinet_id','Invalid Locker ID!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->andWhere(['service_type'=>'store'])->count()==0)
            {
                $model->addError('cabinet_id','You should bind a Store Locker ID!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            if(StoreLockerBindModel::find()->where(['cabinet_id'=>$model->cabinet_id])->count()>0)
            {
                $model->addError('cabinet_id','You can not bind this Locker in two stores!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            if(StoreLockerBindModel::find()->where(['cabinet_id'=>$model->cabinet_id,'oc_store_id'=>$model->oc_store_id])->count()>0)
            {
                $model->addError('cabinet_id','This cabinet and organization bind already exist!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            if($model->save())
            {
                return $this->redirect(['index']);
            }
            else 
            {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrganizationCabinet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $cabinet_id
     * @return mixed
     */
    public function actionUpdate($oc_store_id, $cabinet_id)
    {
        $model = $this->findModel($oc_store_id, $cabinet_id);
       
        if ($model->load(Yii::$app->request->post())) {
            if($model->oldAttributes['cabinet_id']==$model->attributes['cabinet_id'] && $model->oldAttributes['oc_store_id']==$model->attributes['oc_store_id'])
            {
                return $this->redirect(['index']);
            }
            else 
            {
                if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->andWhere(['service_type'=>'store'])->count()==0)
                {
                    $model->addError('cabinet_id','You should bind a Store Locker ID!');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
                if(StoreLockerBindModel::find()->where(['cabinet_id'=>$model->cabinet_id,'oc_store_id'=>$model->oc_store_id])->count()>0)
                {
                    $model->addError('cabinet_id','This cabinet and organization bind already exist!');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
                else
                {
                    $model->save();
                    return $this->redirect(['index']);
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OrganizationCabinet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $cabinet_id
     * @return mixed
     */
    public function actionDelete($oc_store_id=0, $cabinet_id=0)
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $oc_store_id= explode(":", $data['oc_store_id']);
            $oc_store_id= $oc_store_id[0];
            $cabinet_id= explode(":", $data['cabinet_id']);
            $cabinet_id= $cabinet_id[0];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
        $model = $this->findModel($oc_store_id, $cabinet_id);
        //zippora  check store
        if(ZTStoreOrders::find()->where(['cabinet_id'=>$cabinet_id])->andWhere(['pick_time'=> null,'pick_with'=> null])->count()>0)
        {
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'There are some unfinished orders in this Locker.',
                    'code' => 100,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('error', 'There are some unfinished orders in this Locker.');
            }
        }
        else
        {
            $model->delete();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'Delete Store-Locker bind success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete Store-Locker bind success.');
            }
        }
        return $this->redirect(['index']);
        //return $this->redirect(['index']);
    }

    /**
     * Finds the OrganizationCabinet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $cabinet_id
     * @return OrganizationCabinet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($oc_store_id, $cabinet_id)
    {
        if (($model = StoreLockerBindModel::findOne(['oc_store_id' => $oc_store_id, 'cabinet_id' => $cabinet_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

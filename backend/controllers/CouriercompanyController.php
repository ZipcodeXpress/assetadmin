<?php

namespace backend\controllers;

use Yii;
use backend\models\Couriercompany;
use backend\models\CouriercompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Courier;

/**
 * CouriercompanyController implements the CRUD actions for Couriercompany model.
 */
class CouriercompanyController extends CommonController
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
     * Lists all Couriercompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CouriercompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Couriercompany model.
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
     * Creates a new Couriercompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Couriercompany();
        $model->contract_begin = time();
        $model->contract_end = time();

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->validate();
            //var_dump($model);exit;
            if(empty($model->contact_phone))
            {
                $model->addError("contact_phone","Phone can not be empty");
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            else 
            {
                $model->contact_phone = str_replace("-","",$model->contact_phone);
            }
            if($model->save())
            {
                return $this->redirect(['index']);
            }
            else 
            {
                $model->addErrors($model->getErrors());
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
     * Updates an existing Couriercompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) 
        {
            if(empty($model->contact_phone))
            {
                $model->addError("contact_phone","Phone can not be empty");
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            else 
            {
                $model->contact_phone = str_replace("-","",$model->contact_phone);
            }
            if($model->save())
            {
                return $this->redirect(['index']);
            }
            else 
            {
                $model->addErrors($model->getErrors());
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Couriercompany model.
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
        if(Courier::find()->where(['company_id'=>$model->company_id])->count()>0)
        {
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'You should delete the courier data first.',
                    'code' => 100,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('error', 'You should delete the courier data first.');
            }
        }
        else
        {
            $model->delete();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'Delete company success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete company success.');
            }
        }
        return $this->redirect(['index']);
        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Couriercompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Couriercompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Couriercompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

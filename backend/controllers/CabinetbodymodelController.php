<?php

namespace backend\controllers;

use Yii;
use backend\models\Cabinetbodymodel;
use backend\models\CabinetbodymodelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use backend\models\Cabinetbodybox;
use backend\models\Cabinetbody;

/**
 * CabinetbodymodelController implements the CRUD actions for Cabinetbodymodel model.
 */
class CabinetbodymodelController extends CommonController
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
     * Lists all Cabinetbodymodel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CabinetbodymodelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cabinetbodymodel model.
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
     * Creates a new Cabinetbodymodel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cabinetbodymodel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->model_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cabinetbodymodel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->model_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cabinetbodymodel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id=0)
    {
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
            //check body-box
           if(Cabinetbodybox::find()->where(['body_model_id'=>$model->model_id])->count()>0)
            {
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'You should delete the Body-Box data first.',
                        'code' => 100,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('error', 'You should delete the Body-Box data first.');
                    return $this->redirect(['index']);
                }
            }
            //check body
            if(Cabinetbody::find()->where(['body_model_id'=>$model->model_id])->count()>0)
            {
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'You should delete the body data first.',
                        'code' => 100,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('error', 'You should delete the body data first.');
                    return $this->redirect(['index']);
                }
            }
            $model->delete();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'Delete body model success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete body model success.');
            }
            return $this->redirect(['index']);
        }
        catch (\Exception $e){
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
       // $this->findModel($id)->delete();
       // return $this->redirect(['index']);
    }

    /**
     * Finds the Cabinetbodymodel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cabinetbodymodel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cabinetbodymodel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

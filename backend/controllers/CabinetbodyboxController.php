<?php

namespace backend\controllers;

use Yii;
use backend\models\Cabinetbodybox;
use backend\models\CabinetbodyboxSearch;
use backend\models\Cabinetbodymodel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * CabinetbodyboxController implements the CRUD actions for Cabinetbodybox model.
 */
class CabinetbodyboxController extends CommonController
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
     * Lists all Cabinetbodybox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CabinetbodyboxSearch();
        $dataProvider = $searchModel->searchWithBodyModel(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cabinetbodybox model.
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
     * Creates a new Cabinetbodybox model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cabinetbodybox();
        $bodymodel = Cabinetbodybox::getBDM();
        $boxmodel = Cabinetbodybox::getBxM();
        //var_dump($bodyModel);exit();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->body_box_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'bodymodel'=>$bodymodel,
                'boxmodel'=>$boxmodel,
            ]);
        }
    }

    /**
     * Updates an existing Cabinetbodybox model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $bodymodel = Cabinetbodybox::getBDM();
        $boxmodel = Cabinetbodybox::getBxM();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->body_box_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'bodymodel'=>$bodymodel,
                'boxmodel'=>$boxmodel,
            ]);
        }
    }

    /**
     * Deletes an existing Cabinetbodybox model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
        if($this->findModel($id)->delete())
        {
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
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Cabinetbodybox model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cabinetbodybox the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cabinetbodybox::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

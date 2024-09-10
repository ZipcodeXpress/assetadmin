<?php

namespace backend\controllers;

use Yii;
use backend\models\Courier;
use backend\models\CourierSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Store;
use backend\common\RandomHelper;

/**
 * CourierController implements the CRUD actions for Courier model.
 */
class ApmrcourierController extends CommonController
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
                    'reset'=> ['POST'],
                ],
            ],
        ];
    }
    public function actionSearch()
    {
        $model = new Courier();
        $model->setScenario('search');
        if ($model->load(Yii::$app->request->post())) 
        { 
           $post = Yii::$app->request->post();
           $email = $post['Courier']['email'];
           $phone = $post['Courier']['phone'];
           $courier_name = $post['Courier']['courier_name'];
           if(empty($email) && empty($phone) && empty($courier_name))
           {
               return $this->render('search', [
                   'model' => $model,
               ]);
           }
           else 
           return $this->redirect(['index', 'CourierSearch[email]' =>$email,'CourierSearch[phone]' =>$phone,'CourierSearch[courier_name]' =>$courier_name,]);
        } else {
            return $this->render('search', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Lists all Courier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReset($id)
    {
        $model = $this->findModel($id);
        $model->card_code = strval(RandomHelper::get_random_number(6));
        if($model->save())
        {
           \Yii::$app->getSession()->setFlash('success', 'Reset access code success.');
        }
        else 
        {
            \Yii::$app->getSession()->setFlash('error', $model->getErrors());
        }
        return $this->redirect(['index']);
    }
    /**
     * Displays a single Courier model.
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
     * Creates a new Courier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courier(); 
        $model->card_code = strval(RandomHelper::get_random_number(6));
        if ($model->load(Yii::$app->request->post())) 
        { 
            if(empty($model->phone))
            {
                $model->addError("phone","Phone can not be empty");
                return $this->render('create', [
                    'model' => $model,
                    'companyModel'=>Courier::getCompanyName(),
                ]);
            }
            else 
            {
                $model->phone = str_replace("-","",$model->phone);
            }
            if(str_replace(" ", "",strtolower(Yii::$app->user->identity->usergroup['item_name']))=='organizationmanager')
            {
                $model->card_code = strval(RandomHelper::get_random_number(6));
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
                    'companyModel'=>Courier::getCompanyName(),
                ]);
            }
            //return $this->redirect(['view', 'id' => $model->courier_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'companyModel'=>Courier::getCompanyName(),
            ]);
        }
    }

    /**
     * Updates an existing Courier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->courier_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'companyModel'=>Courier::getCompanyName(),
            ]);
        }
    }

    /**
     * Deletes an existing Courier model.
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
        if(Store::find()->where(['courier_id'=>$model->courier_id])->count()>0)
        {
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'This courier has store data, so cannot be deleted.',
                    'code' => 100,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('error', 'This courier has store data, so cannot be deleted.');
            }
        }
        else
        {
            $model->delete();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'Delete courier success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete courier success.');
            }
        }
        return $this->redirect(['index']);
        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Courier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Courier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

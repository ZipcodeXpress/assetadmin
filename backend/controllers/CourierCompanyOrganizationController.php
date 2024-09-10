<?php

namespace backend\controllers;

use Yii;
use backend\models\CourierCompanyOrganization;
use backend\models\CourierCompanyOrganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Couriercompany;
use backend\components\Helper;
use backend\common\RandomHelper;
use backend\models\Courierorganization;

/**
 * CabinetCourierCompanyOrganizationController implements the CRUD actions for CourierCompanyOrganization model.
 */
class CourierCompanyOrganizationController extends CommonController
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
     * Lists all CourierCompanyOrganization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourierCompanyOrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourierCompanyOrganization model.
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
     * Creates a new CourierCompanyOrganization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourierCompanyOrganization();
        $company = Helper::getCompany();
        $organizations = Helper::getOrganizations();
        
        $model->access_code = RandomHelper::get_random_number(6);

        if ($model->load(Yii::$app->request->post())) 
        {
            if(CourierCompanyOrganization::find()->where(['company_id'=>$model->company_id,'organization_id'=>$model->organization_id])->count()>0)
            {
                $model->addError("organization_id","Courier already exist in this company and organization.");
                return $this->render('create', [
                    'model' => $model,
                    'company'=>$company,
                    'organizations'=>$organizations,
                ]);
            }
            else
            {
                $model->create_time = time();
                $model->save();
                $courier_id = $model->attributes['courier_id'];
                //check and authorized
                if(Courierorganization::find()->where(['courier_id'=>$courier_id,'organization_id'=>$model->organization_id])->count()==0)
                {
                    $courierOrganizationModel = new Courierorganization();
                    $courierOrganizationModel->courier_id = $courier_id;
                    $courierOrganizationModel->organization_id = $model->organization_id;
                    $courierOrganizationModel->create_time = time();
                    $courierOrganizationModel->save();
                }
                else 
                {
                    \Yii::$app->getSession()->setFlash('error', 'This courier already authorized to this organization.');
                }
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'company'=>$company,
            'organizations'=>$organizations,
        ]);
    }

    /**
     * Updates an existing CourierCompanyOrganization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $company = Helper::getCompany();
        $organizations = Helper::getOrganizations();

        if ($model->load(Yii::$app->request->post()))
        {
            if(CourierCompanyOrganization::find()->where(['company_id'=>$model->company_id,'organization_id'=>$model->organization_id])->andWhere(['<>','create_time',$model->create_time])->count()>0)
            {
                $model->addError("organization_id","Courier already exist in this company and organization.");
                return $this->render('create', [
                    'model' => $model,
                    'company'=>$company,
                    'organizations'=>$organizations,
                ]);
            }
             $model->save();
             return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'company'=>$company,
            'organizations'=>$organizations,
        ]);
    }

    /**
     * Deletes an existing CourierCompanyOrganization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CourierCompanyOrganization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourierCompanyOrganization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourierCompanyOrganization::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

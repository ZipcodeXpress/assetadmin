<?php

namespace backend\controllers;

use Yii;
use backend\models\CabinetAdminCard;
use backend\models\CabinetAdminCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use yii\helpers\ArrayHelper;
use backend\models\Cabinet;
use backend\models\OrganizationCabinet;

/**
 * CabinetAdminCardController implements the CRUD actions for CabinetAdminCard model.
 */
class CabinetAdminCardController extends CommonController
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
     * Lists all CabinetAdminCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CabinetAdminCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CabinetAdminCard model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function getLockers()
    {
        $lockers = [];
        if(strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin')
        {
            $lockers = Cabinet::find()->all();
            $lockers = ArrayHelper::map($lockers, "cabinet_id", "cabinet_id");
        }
        else
        {
            $organizations = [];
            if($this->_organizationIds)
            {
                $apt_ids = array_filter(explode(',', $this->_organizationIds));
                foreach ($apt_ids as $key=>$id)
                {
                    $organization = OrganizationCabinet::findOne(['organization_id'=>$id]);
                    if(!empty($organization))
                    {
                        $lockers[$organization->cabinet_id] = $organization->cabinet_id;
                    }
                }
            }
        }
        return $lockers;
    }
    /**
     * Creates a new CabinetAdminCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CabinetAdminCard();
        
        $userData = User::find()->joinWith('usergroup')->all(); 
        $user = ArrayHelper::map($userData, 'id', 'username');
        $lockers = $this->getLockers();

        if ($model->load(Yii::$app->request->post())) 
        {
            if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->count()==0)
            {
                $model->addError('cabinet_id','Invalid Locker ID!');
                return $this->render('create', [
                    'model' => $model,
                    'user'=>$user,
                    'lockers'=>$lockers,
                ]);
            }
//             if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->andWhere(['service_type'=>'zippora'])->count()==0)
//             {
//                 $model->addError('cabinet_id','You should bind a Zippora Locker ID!');
//                 return $this->render('create', [
//                     'model' => $model,
//                     'user'=>$user,
//                     'lockers'=>$lockers,
//                 ]);
//             }
            $admin = User::find()->joinWith('usergroup')->where(['id'=>$model->zp_admin_id])->joinWith('usergroup')->one();
            $model->zp_admin_name = $admin->username;
            $model->zp_admin_role = $admin['usergroup']['item_name'];
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'user'=>$user,
            'lockers'=>$lockers,
        ]);
    }

    /**
     * Updates an existing CabinetAdminCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $userData = User::find()->joinWith('usergroup')->all();
        $user = ArrayHelper::map($userData, 'id', 'username');
        $lockers = $this->getLockers();

        if ($model->load(Yii::$app->request->post())) 
        {
            $admin = User::find()->joinWith('usergroup')->where(['id'=>$model->zp_admin_id])->joinWith('usergroup')->one();
            $model->zp_admin_name = $admin->username;
            $model->zp_admin_role = $admin['usergroup']['item_name'];
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'user'=>$user,
            'lockers'=>$lockers,
        ]);
    }

    /**
     * Deletes an existing CabinetAdminCard model.
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
     * Finds the CabinetAdminCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CabinetAdminCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CabinetAdminCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

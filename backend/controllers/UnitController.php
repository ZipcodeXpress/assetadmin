<?php

namespace backend\controllers;

use Yii;
use backend\models\Unit;
use backend\models\UnitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Memberorganization;
use yii\web\UploadedFile;
use backend\models\Organization;
use yii\helpers\ArrayHelper;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends CommonController
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
     * Lists all Unit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unit model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function getOrganizations()
    {
        $organizations = [];
        if(strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin')
        {
            $organizations = Organization::find()->all();
            $organizations = ArrayHelper::map($organizations, "organization_id", "organization_name");
        }
        else
        {
            $organizations = [];
            if($this->_organizationIds)
            {
                $apt_ids = array_filter(explode(',', $this->_organizationIds));
                foreach ($apt_ids as $key=>$id)
                {
                    $organization = Organization::findOne(['organization_id'=>$id]);
                    if(!empty($organization))
                    {
                        $organizations[$organization->organization_id] = $organization->organization_name;
                    }
                }
            }
        }
        return $organizations;
    }
    /**
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unit();
        $organizations = $this->getOrganizations();

        if ($model->load(Yii::$app->request->post())) {
            $organization_id = $model->organization_id;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $v1=$model->file->tempName;
                $file = fopen($model->file->tempName,'r'); 
                while ($data = fgetcsv($file)) {
                    $units[] = $data;
                 }
                //var_dump($units);exit;
                foreach ($units as $arr){
                       if(!empty($arr))
                       {
                           foreach ($arr as $unit)
                           {
                               if($this->CheckUnit($unit, $organization_id))
                               {
                                   continue;
                               }
                               else
                               {
                                   $_model=clone $model;
                                   $_model->unit_name = $unit;
                                   $_model->save();
                               }
                           }
                       }
                }
                fclose($file);
                return $this->redirect(['index']);
            }
            else 
            { 
                $data=explode(",",$model->unit_name);
                foreach ($data as $arr){
                   if(!empty($arr))
                   {
                       if($this->CheckUnit($arr, $organization_id))
                       {
                            $model->addError('unit_name','Business Unit already exist!');
                            return $this->render('create', [
                                'model' => $model,
                                'organizations'=> $organizations,
                            ]);
                       }
                       else
                       {
                           $_model=clone $model;
                           $_model->unit_name = $arr;
                           $_model->save();
                       }
                   }
                }
                return $this->redirect(['index']);
            }
            
            //return $this->redirect(['view', 'id' => $model->unit_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'organizations'=> $organizations,
            ]);
        }
    }
    protected function  CheckUnit($unit_name,$organization_id)
    {
        return Unit::find()->where(['unit_name'=>$unit_name,'organization_id'=>$organization_id])->count()>0;
    }
    /**
     * Updates an existing Unit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $organizations = $this->getOrganizations();

        if ($model->load(Yii::$app->request->post())) {
            $nCount = Unit::find()->where(['unit_name'=>$model->unit_name,'organization_id'=>$model->organization_id])->andWhere(['<>','unit_id',$model->unit_id])->count();
            if($nCount>0)
            {
                $model->addError('unit_name','Business Unit and Organization already exist!');
                return $this->render('create', [
                    'model' => $model,
                    'organizations'=> $organizations,
                ]);
            }
            else 
            {
                $model->save();
                return $this->redirect(['index']);
            }
            //return $this->redirect(['view', 'id' => $model->unit_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'organizations'=> $organizations,
            ]);
        }
    }

    /**
     * Deletes an existing Unit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
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
            //check member organization bind
            if(Memberorganization::find()->where(['unit_id'=>$model->unit_id])->count()>0)
            {
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'There is a member already bind this unit.',
                        'code' => 100,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('error', 'There is a member already bind this unit.');
                    return $this->redirect(['index']);
                }
            }
            $model->delete();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'Delete unit success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete unit success.');
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
        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the Unit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Unit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

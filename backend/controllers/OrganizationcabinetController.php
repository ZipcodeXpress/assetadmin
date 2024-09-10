<?php

namespace backend\controllers;

use Yii;
use backend\models\OrganizationCabinet;
use backend\models\OrganizationCabinetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Cabinet;
use backend\models\Store;

/**
 * OrganizationCabinetController implements the CRUD actions for OrganizationCabinet model.
 */
class OrganizationcabinetController extends CommonController
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
        $searchModel = new OrganizationCabinetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrganizationCabinet model.
     * @param integer $organization_id
     * @param integer $cabinet_id
     * @return mixed
     */
    public function actionView($organization_id, $cabinet_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($organization_id, $cabinet_id),
        ]);
    }

    /**
     * Creates a new OrganizationCabinet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrganizationCabinet();
        
        if ($model->load(Yii::$app->request->post())) {
            if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->count()==0)
            {
                $model->addError('cabinet_id','Invalid Locker ID!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
//             if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->andWhere(['service_type'=>'zippora'])->count()==0)
//             {
//                 $model->addError('cabinet_id','You should bind a Zippora Locker ID!');
//                 return $this->render('create', [
//                     'model' => $model,
//                 ]);
//             }
            if(OrganizationCabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->count()>0)
            {
                $model->addError('cabinet_id','You can not bind this Locker in two places!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            if(OrganizationCabinet::find()->where(['cabinet_id'=>$model->cabinet_id,'organization_id'=>$model->organization_id])->count()>0)
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
            //return $this->redirect(['view', 'organization_id' => $model->organization_id, 'cabinet_id' => $model->cabinet_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OrganizationCabinet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $organization_id
     * @param integer $cabinet_id
     * @return mixed
     */
    public function actionUpdate($organization_id, $cabinet_id)
    {
        $model = $this->findModel($organization_id, $cabinet_id);
       
        if ($model->load(Yii::$app->request->post())) {
            if($model->oldAttributes['cabinet_id']==$model->attributes['cabinet_id'] && $model->oldAttributes['organization_id']==$model->attributes['organization_id'])
            {
                return $this->redirect(['index']);
            }
            else 
            {
                if(Cabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->andWhere(['service_type'=>'zippora'])->count()==0)
                {
                    $model->addError('cabinet_id','You should bind a Zippora Locker ID!');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
                if(OrganizationCabinet::find()->where(['cabinet_id'=>$model->cabinet_id,'organization_id'=>$model->organization_id])->count()>0)
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
     * @param integer $organization_id
     * @param integer $cabinet_id
     * @return mixed
     */
    public function actionDelete($organization_id=0, $cabinet_id=0)
    {
        if (Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post(); //var_dump($data);
            $organization_id= explode(":", $data['organization_id']);
            $organization_id= $organization_id[0];
            $cabinet_id= explode(":", $data['cabinet_id']);
            $cabinet_id= $cabinet_id[0];
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
        $model = $this->findModel($organization_id, $cabinet_id);
        //zippora  check store
        if(Store::find()->where(['cabinet_id'=>$cabinet_id])->andWhere(['pick_time'=> null,'pick_with'=> null])->count()>0)
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
                    'msg' => 'Delete Organization-Locker bind success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete Organization-Locker bind success.');
            }
        }
        return $this->redirect(['index']);
        //$this->findModel($organization_id, $cabinet_id)->delete();
        //return $this->redirect(['index']);
    }

    /**
     * Finds the OrganizationCabinet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $organization_id
     * @param integer $cabinet_id
     * @return OrganizationCabinet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($organization_id, $cabinet_id)
    {
        if (($model = OrganizationCabinet::findOne(['organization_id' => $organization_id, 'cabinet_id' => $cabinet_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

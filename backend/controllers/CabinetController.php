<?php

namespace backend\controllers;

use Yii;
use backend\models\Cabinet;
use backend\models\CabinetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Cabinetbodybox;
use backend\models\Cabinetbody;
use backend\models\Cabinetbox;
use backend\models\OrganizationCabinet;
use backend\models\Store;
use backend\models\Zdeliver;

/**
 * CabinetController implements the CRUD actions for Cabinet model.
 */
class CabinetController extends CommonController
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
     * Lists all Cabinet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CabinetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);
        
        $cabinet_actions = array('cabinet/create','cabinet/update','cabinet/delete');
        $cans=[];
        foreach ($cabinet_actions as $actKey => $act)
        {
           $cans[$actKey] = Yii::$app->user->can($act);
        }
        $IsShowCreate = false;
        if($cans[0]) $IsShowCreate = true;
        $template="";
        if($cans[1])
        {
            $template = $template."{update}";
        }
        if($cans[2])
        {
            $template = $template." {delete}";
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template'=>$template,
            'IsShowCreate'=>$IsShowCreate
        ]);
    }
    public function actionCreatebox($cabinet_id)
    {
//         $box_arr = [];
//         $body_list = Cabinetbody::find()->where(['cabinet_id'=>$cabinet_id])->all();
        
//         foreach ($body_list as $body_key=>$body)
//         {
//             $body_box_list = Cabinetbodybox::find()->where(['body_model_id'=>$body['body_model_id']])->all();
//             foreach ($body_box_list as $body_box_key=>$body_box)
//             {
//                 $box_arr[] = [
//                     'box_model_id' => $body_box['box_model_id'],
//                     'cabinet_id' => $body['cabinet_id'],
//                     'body_id' => $body['body_id'],
//                     'row' => $body_box['row'],
//                     'column' => $body_box['column'],
//                     'addr' => $body_box['addr'],
//                 ];
//             }
//         }
//         $model = new Cabinetbox();
//         foreach($box_arr as $attributes){
//              $_model=clone $model;
//              $_model->setAttributes($attributes);
//              $_model->save();
//         }
        return $this->redirect(['cabinetbox/index']);
    }
    /**
     * Displays a single Cabinet model.
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
     * Creates a new Cabinet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cabinet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->cabinet_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cabinet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->cabinet_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cabinet model.
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
            //check body
            if(Cabinetbody::find()->where(['cabinet_id'=>$model->cabinet_id])->count()>0)
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
            //check box
            if(Cabinetbox::find()->where(['cabinet_id'=>$model->cabinet_id])->count()>0)
            {
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'You should delete the box data first.',
                        'code' => 100,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('error', 'You should delete the box data first.');
                    return $this->redirect(['index']);
                }
            }
            //check organization_cabinet bind
            if(OrganizationCabinet::find()->where(['cabinet_id'=>$model->cabinet_id])->count()>0)
            {
                if(Yii::$app->request->isAjax)
                {
                    return [
                        'msg' => 'You should delete the Organization-Locker bind data first.',
                        'code' => 100,
                    ];
                }
                else
                {
                    \Yii::$app->getSession()->setFlash('error', 'You should delete the Organization-Locker bind data first.');
                    return $this->redirect(['index']);
                }
            }
            if($model->service_type=='zippora')
            {
                //check orders
                if(Store::find()->where(['cabinet_id'=>$model->cabinet_id])->andWhere(['pick_time'=> null,'pick_with'=> null])->count()>0)
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
                        return $this->redirect(['index']);
                    }
                }
            }
            else
            {
                //check deliver
                if(Zdeliver::find()->where(['from_cabinet_id'=>$model->cabinet_id])->count()>0 || Zdeliver::find()->where(['to_cabinet_id'=>$model->cabinet_id])->count()>0)
                {
                    if(Yii::$app->request->isAjax)
                    {
                        return [
                            'msg' => 'There are some deliver orders in this Locker.',
                            'code' => 100,
                        ];
                    }
                    else
                    {
                        \Yii::$app->getSession()->setFlash('error', 'There are some deliver orders in this Locker.');
                        return $this->redirect(['index']);
                    }
                }
            }
            $model->delete();
            if(Yii::$app->request->isAjax)
            {
                return [
                    'msg' => 'Delete Locker success.',
                    'code' => 200,
                ];
            }
            else
            {
                \Yii::$app->getSession()->setFlash('success', 'Delete Locker success.');
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
    }

    /**
     * Finds the Cabinet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cabinet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cabinet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

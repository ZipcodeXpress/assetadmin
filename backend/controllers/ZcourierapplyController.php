<?php

namespace backend\controllers;

use Yii;
use backend\models\Zcourierapply;
use backend\models\ZcourierapplySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Member;

/**
 * ZcourierapplyController implements the CRUD actions for Zcourierapply model.
 */
class ZcourierapplyController extends CommonController
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
     * Lists all Zcourierapply models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZcourierapplySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Zcourierapply model.
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
     * Creates a new Zcourierapply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new Zcourierapply();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->apply_id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing Zcourierapply model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $model = $this->findModel($id);
            
            if ($model->load(Yii::$app->request->post())) {
                $model->process_time = time();
                $model->process_by = Yii::$app->user->identity->id;
                $model->save();
                //审核通过
                if($model->process_result==2)
                {
                    $member = Member::findOne(['member_id'=>$model->courier_id]);
                    //register compeleted
                    $member->c_status=0;
                    $member->save();
                }
                $transaction->commit();
                return $this->redirect(['index']);
            } else {
                $model->addError('Approve failed！');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
        catch (\Exception $e)
        {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            $model->addError('Approve failed！');
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        
        
    }

    /**
     * Deletes an existing Zcourierapply model.
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
     * Finds the Zcourierapply model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zcourierapply the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zcourierapply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

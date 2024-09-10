<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductCategory;
use backend\models\ProductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Organization;
use backend\models\Product;
use yii\helpers\ArrayHelper;

/**
 * ProductcategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductcategoryController extends CommonController
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
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
            

        $searchModel = new ProductCategorySearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);
//var_dump($dataProvider);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           
        ]);
    }

    /**
     * Displays a single ProductCategory model.
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
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function getOrganizations()
    {
        $organizations = [];
        if (strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin') {
            $organizations = Organization::find()->all();
            $organizations = ArrayHelper::map($organizations, "organization_id", "organization_name");
        } else {
            $organizations = [];
            if ($this->_organizationIds) {
                $apt_ids = array_filter(explode(',', $this->_organizationIds));
                foreach ($apt_ids as $key => $id) {
                    $organization = Organization::findOne(['organization_id' => $id]);
                    if (!empty($organization)) {
                        $organizations[$organization->organization_id] = $organization->organization_name;
                    }
                }
            }
        }
        return $organizations;
    }

    public function actionCreate()
    {
        $model = new ProductCategory();
        $organizations = $this->getOrganizations();
        if ($model->load(Yii::$app->request->post()) ) {
            $organization_id = $model->organization_id;
            //   return $this->redirect(['view', 'id' => $model->product_cate_id]);
            $data=explode(",",$model->product_cate_name);
            foreach ($data as $arr){
               if(!empty($arr))
               {
                   if($this->CheckProdCate($arr, $organization_id))
                   {
                        $model->addError('product_cate_name','product catagory Name already exist!');
                        return $this->render('create', [
                            'model' => $model,
                            'organizations'=> $organizations,
                        ]);
                   }
                   else
                   {
                       $_model=clone $model;
                       $_model->product_cate_name = $arr;
                       $_model->save();
                   }
               }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'organizations'=> $organizations,
            ]);
        }
    }
    protected function  CheckProdCate($product_cate_name,$organization_id)
    {
        return ProductCategory::find()->where(['product_cate_name'=>$product_cate_name,'organization_id'=>$organization_id])->count()>0;
    }
    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $organizations = $this->getOrganizations();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->product_cate_id]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'organizations'=> $organizations,
                
            ]);
        }
    }

    /**
     * Deletes an existing ProductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id=0)
    {
        //  $this->findModel($id)->delete();
       
        try {
            if (Yii::$app->request->isAjax) {
                $data = Yii::$app->request->post(); 
                $id = explode(":", $data['id']);
                $id = $id[0];
               // var_dump($id);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            }
            $model = $this->findModel($id);
           
            //check product
            if (Product::find()->where(['category_id' => $model->product_cate_id])->count() > 0) {
                if (Yii::$app->request->isAjax) {
                    return [
                        'msg' => 'You should delete the product data first.',
                        'code' => 100,
                    ];
                } else {
                    \Yii::$app->getSession()->setFlash('error', 'You should delete the product data first.');
                    return $this->redirect(['index']);
                }
            }
            
           
            $model->delete();
            if (Yii::$app->request->isAjax) {
                return [
                    'msg' => 'Delete product category success.',
                    'code' => 200,
                ];
            } else {
                \Yii::$app->getSession()->setFlash('success', 'Delete product category success.');
            }
            return $this->redirect(['index']);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (Yii::$app->request->isAjax) {
                return [
                    'msg' => $msg+"sss",
                    'code' => 200,
                ];
            } else {
                \Yii::$app->getSession()->setFlash('error123', $msg);
            }
        }
    }
    //   return $this->redirect(['index']);


    /**
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        } else
{
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
}

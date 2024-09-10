<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductInventory;
use backend\models\ProductInventorySearch;
use backend\models\Product;
use backend\models\ProductRental;
use yii\web\Controller;
use backend\models\Organization;
use backend\models\Cabinetbox;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * ProductInventoryController implements the CRUD actions for ProductInventory model.
 */
class ProductinventoryController extends CommonController
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
     * Lists all ProductInventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductInventorySearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductInventory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)



    {
        $productrental = ProductRental::findAll(['product_inventory_id' => $id]);
        $product = $this::getProduct();
        $organizations = $this->getOrganizations();
      
        return $this->render('view', [
            'model' => $this->findModel($id),
            'product' => $product,
            'organizations' => $organizations,
            'productrental' => $productrental,
           
        ]);
    }

    /**
     * Creates a new ProductInventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductInventory();
        $product = $this::getProduct();
        $organizations = $this->getOrganizations();
        $inistatuscode = 0;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'product' => $product,
                'organizations' => $organizations,
                'inistatuscode' => $inistatuscode,
            ]);
        }
    }

    /**
     * Updates an existing ProductInventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $product = $this::getProduct();
        $organizations = $this->getOrganizations();
        $productrental = ProductRental::findAll(['product_inventory_id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_inventory_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'product' => $product,
                'organizations' => $organizations,
                'productrental' => $productrental,
            ]);
        }
    }

    /**
     * Deletes an existing ProductInventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$productinventor = [];
		$productinventor = ProductRental::find()->where(['product_inventory_id' => $id])->all();
		if ($productinventor!== null)
		{}
	    else
		{	
         $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductInventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductInventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductInventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getProduct()
    {


        $product = [];
        if (strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin') {
            $product = Product::find()->all();
            $product = ArrayHelper::map($product, "product_id", "product_name");
        } else {
            if (Yii::$app->user->identity->organization_ids)
                $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));

            foreach ($apt_ids as $key => $id) {
                $product = Product::find()->where(['organization_id' => $id])->all();
                $product = ArrayHelper::map($product, 'product_id', 'product_name');
            }
        }


        return $product;
    }

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
}

<?php

namespace backend\controllers;

use Yii;
use common\components\Aliyunoss;
use backend\models\Product;
use backend\models\ProductInventory;
use backend\models\ProductCategory;
use backend\models\Cabinetboxmodel;
use backend\models\ProductCategorySearch;
use backend\models\ProductSearch;
use backend\models\Organization;
use backend\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\db\ActiveRecord;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends CommonController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);
        //$model = new Product();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionDeletefile($id)
    {
        $model = $this->findModel($id);
        $product_image = $model->product_image;
        $product_thumbnail = $model->product_thumbnail;

        //unlink($product_image);
        //unlink($product_thumbnail);
        $is_delp = Yii::$app->Aliyunoss->delete($product_image);
        if ($is_delp) {
            $is_del = Yii::$app->Aliyunoss->delete($product_thumbnail);
            if ($is_del) {
                $model->product_image = null;
                $model->product_thumbnail = null;
                $model->save();
            }
        }
        return $this->redirect(['update', 'id' => $id]);
    }
    /**
     * Displays a single Product model.
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
     * Product created only for the company(organizationID as the foreign key).
     * so need to find the organization first and the products belong to the organization.
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
    public  function  getBoxmodel()
    {

        $boxmodel = [];

        $boxmodel = Cabinetboxmodel::find()->all();
        $boxmodel = ArrayHelper::map($boxmodel, 'model_id', 'model_name');
        return $boxmodel;
    }


    public  function getProductcategory()
    {


        $productcategory = [];
        if (strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin') {
            $productcategory = ProductCategory::find()->all();
            $productcategory = ArrayHelper::map($productcategory, "product_cate_id", "product_cate_name");
        } else {
            if (Yii::$app->user->identity->organization_ids)
                $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));

            foreach ($apt_ids as $key => $id) {
                $productcategory = ProductCategory::find()->where(['organization_id' => $id])->all();
                $productcategory = ArrayHelper::map($productcategory, 'product_cate_id', 'product_cate_name');
            }
        }


        return $productcategory;
    }
    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $productcategory = $this::getProductcategory();
        $organizations = $this->getOrganizations();
        $boxmodel = $this->getBoxmodel();
        $vd = $this->getDir();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {

                $imageName = Yii::$app->security->generateRandomString();
                $file = 'uploads/' . $imageName . '.' . $model->imageFile->extension;

                $ossfile = $file;
                $model->product_image = $file;

                $thumbfile = 'uploads/thumb/' . $imageName . '.' . $model->imageFile->extension;
                $ossthumbfile = $thumbfile;
                $model->product_thumbnail = $thumbfile;

                if (!$model->save(false)) {         //保存不成功

                    $errors = $model->getErrors();
                    echo print_r($errors);
                    exit;
                }
                //
                $model->imageFile->saveAs($file);
                $ossupload = Yii::$app->Aliyunoss->upload($ossfile, $file);
                //文件上传到阿里云oss
                if ($ossupload)
                // 如果上传成功，
                {
                    Image::thumbnail($file, 200, 200)->save($thumbfile, ['quality' => 80]);
                    //Image::thumbnail($file, 100, 75)->save($thumbfile, ['quality' => 100]);

                    $ossthumbupload = Yii::$app->Aliyunoss->upload($ossthumbfile, $thumbfile);
                    //文件上传到阿里云oss
                    if ($ossthumbupload) {
                        // 如果上传成功，
                        unlink($file);
                        unlink($thumbfile);
                    }
                }
                //
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'productcategory' => $productcategory,
                'organizations' => $organizations,
                'boxmodel' => $boxmodel,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //$model = new Product();
        $model = $this->findModel($id);
        $productcategory = $this::getProductcategory();
        $organizations = $this->getOrganizations();
        $boxmodel = $this->getBoxmodel();

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                if ($model->product_image) {
                    $model->addError('imageFile', 'Please delete the previous image first');
                    return $this->render('update', [
                        'model' => $model,
                        'productcategory' => $productcategory,
                        'organizations' => $organizations,
                        'boxmodel' => $boxmodel,
                    ]);
                }

                $imageName = Yii::$app->security->generateRandomString();
                $file = 'uploads/' . $imageName . '.' . $model->imageFile->extension;
                $ossfile = $file;
                $thumbfile = 'uploads/thumb/' . $imageName . '.' . $model->imageFile->extension;
                $ossthumbfile = $thumbfile;
                $model->product_image = $file;

                $model->product_thumbnail = $thumbfile;

                if (!$model->save(false)) {         //保存不成功

                    $errors = $model->getErrors();
                    echo print_r($errors);
                    exit;
                }

                $model->imageFile->saveAs($file);
                $ossupload = Yii::$app->Aliyunoss->upload($ossfile, $file);
                //文件上传到阿里云oss
                if ($ossupload)
                // 如果上传成功，
                {
                    Image::thumbnail($file, 200, 200)->save($thumbfile, ['quality' => 80]);
                    //Image::thumbnail($file, 100, 75)->save($thumbfile, ['quality' => 100]);
                    $ossthumbupload = Yii::$app->Aliyunoss->upload($ossthumbfile, $thumbfile);
                    //文件上传到阿里云oss
                    if ($ossthumbupload) {
                        // 如果上传成功，
                        unlink($file);
                        unlink($thumbfile);
                    }
                }
            } else {
                $model->save();
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'productcategory' => $productcategory,
                'organizations' => $organizations,
                'boxmodel' => $boxmodel,
            ]);
        }
    }


    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the ' index ' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$productinventor = [];
		$productinventor = ProductInventory::find()->where(['product_id' => $id])->all();
		if ($productinventor!== null)
		{}
	    else
		{	
         $this->findModel($id)->delete();
        }
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(' The requested page does not  e xist.');
        }
    }

    protected  function getDir()
    {
        //$dir = Yii::$app->basePath . '/web/uploads/';
        $dir = Yii::$app->basePath . '/web/uploads/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
            mkdir($dir . ' thumb/', 0777, true);
            chmod($dir . ' thumb/', 0777);
        }
        return $dir;
    }
}

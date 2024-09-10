<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductAuth;
use backend\models\ProductAuthSearch;
use backend\models\Member;
use backend\models\Product;
use backend\models\Organization;
use backend\models\Memberorganization;
use backend\models\Memberprofile;
use Imagine\Image\Profile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * ProductauthController implements the CRUD actions for ProductAuth model.
 */
class ProductauthController extends CommonController
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
     * Lists all ProductAuth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductAuthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $this->_organizationIds);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductAuth model.
     * @param integer $product_id
     * @param integer $member_id
     * @return mixed
     */
    public function actionView($product_id, $member_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($product_id, $member_id),
        ]);
    }

    /**
     * Creates a new ProductAuth model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductAuth();
        // $product = $this->getProduct();
        $members = [];
        $product = [];
        $organizations = $this->getOrganizations();
        $inistatuscode = 0;

        try {
            if (Yii::$app->request->post()) {
                $post = Yii::$app->request->post();
                //  $model->member_id = $post['ProductAuth']['member_id'];
                //  $model->product_id = $post['ProductAuth']['product_id'];
                $model->organization_id = $post['ProductAuth']['organization_id'];
                $model->product_id = isset($post['ProductAuth']['product_id']) ? $post['ProductAuth']['product_id'] : null;
                $model->member_id = isset($post['ProductAuth']['member_id']) ? $post['ProductAuth']['member_id'] : null;
                $model->created_time = time();
                $model->approve_status = 0;
                $model->auth_code = 0;
                if (empty($model->product_id)) {
                    $model->addError('product_id', 'Product can not be empty, please select the product.');
                    return $this->render('create', [
                        'model' => $model,
                        'product' => $product,
                        'members' => $members,
                        'organizations' => $organizations,
                        'inistatuscode' => $inistatuscode,
                    ]);
                }
                if (empty($model->member_id)) {
                    $model->addError('member_id', 'Member can not be empty, please select the member.');
                    return $this->render('create', [
                        'model' => $model,
                        'product' => $product,
                        'members' => $members,
                        'organizations' => $organizations,
                        'inistatuscode' => $inistatuscode,
                    ]);
                }
                if (ProductAuth::find()->where(['member_id' => $model->member_id, 'product_id' => $model->product_id])->count() > 0) {
                    $model->addError('member_id', 'This user already has been authorized to this product.');
                    return $this->render('create', [
                        'model' => $model,
                        'product' => $product,
                        'members' => $members,
                        'organizations' => $organizations,
                        'inistatuscode' => $inistatuscode,
                    ]);
                }
                $model->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'product' => $product,
                    'members' => $members,
                    'organizations' => $organizations,
                    'inistatuscode' => $inistatuscode,
                ]);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $model->addError('member_id', (stristr($msg, 'duplicate entry')) ? "This user already has been authorized to this product." : $e->getMessage());
            return $this->render('create', [
                'model' => $model,
                'product' => $product,
                'members' => $members,
                'organizations' => $organizations,
                'inistatuscode' => $inistatuscode,
            ]);
        }
    }

    public function actionApprove($product_id, $member_id)
    {
        $model = $this->findModel($product_id, $member_id);
        //approved-->cancel
        if ($model->approve_status == 1) {
            //cancel-->recover
            if ($model->auth_code == 3) {
                $model->auth_code = 1;
                $model->approve_status = 1;
                $model->cancel_time = 0;
                $model->approve_time = time();
            } else {
                //approved-->cancel

                $model->auth_code = 3;
                $model->approve_status = 0;
                $model->cancel_time = time();
            }
        } else if ($model->approve_status == 0) {
            $model->approve_status = 1;
            $model->auth_code = 1;
            $model->cancel_time = 0;
            $model->approve_time = time();
        }
        $model->save();
        return $this->redirect(['index']);
    }
    /**
     * Updates an existing ProductAuth model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $product_id
     * @param integer $member_id
     * @return mixed
     */
    public function actionUpdate($product_id, $member_id)
    {
        $model = $this->findModel($product_id, $member_id);
        //  $product = $this::getProduct();
        $productname = ProductAuth::getProductName();
        //   $member = $this->getMember();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'product_id' => $model->product_id, 'member_id' => $model->member_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProductAuth model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $member_id
     * @return mixed
     */
    public function actionDelete($product_id, $member_id)
    {
        $this->findModel($product_id, $member_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductAuth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $member_id
     * @return ProductAuth the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $member_id)
    {
        if (($model = ProductAuth::findOne(['product_id' => $product_id, 'member_id' => $member_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*  public function getProduct()
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
    } */

    public function actionProductlist()
    {
        if ($id = Yii::$app->request->post('id')) {

            $product = Product::find()->where(['organization_id' => $id])->andWhere(['is_public' => 0])->orderBy('product_name')->all();
            if (!empty($product)) {
                foreach ($product as $product) {
                    echo "<option value='" . $product->product_id . "'>" . $product->product_name . "</option>";
                }
            } else {
                echo "<option>This no product for this organization</option>";
            }
        }
    }

    public function actionMemberlist()
    {
        if ($id = Yii::$app->request->post('id')) {

            $members = Memberorganization::find()->select('o_member_organization.member_id, member.email, member_profile.last_name,member_profile.first_name')
                ->joinWith('member')->joinWith('memberprofile')->where(['organization_id' => $id])->all();
            $members = ArrayHelper::map($members, "member_id",     function ($model) {
                return $model['first_name'] . '   ' . $model['last_name'] . '   email:' . $model['email'];
            });
            if (!empty($members)) {

                foreach ($members as $key => $value) {
                    echo "<option value='" . $key . "'>" . $value . "</option>";
                }
            } else {
                echo "<option>This no member for this organization</option>";
            }
        }
    }
    public function getOrganizations()
    {
        $organizations = [];
        if (strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin') {
            $organizations = Organization::find()->all();
            $organizations = ArrayHelper::map($organizations, "organization_id", "organization_name");
        } else {
            //   $organizations = [];
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

    private $fullInfo;


    public function getMembers()
    {


        $members = [];

        if (strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin') {
            $members = Member::find()->select('member.member_id, email, member_profile.last_name,member_profile.first_name')->joinWith('profile')->all();
            //      $data[$members->member_id]=$members->email.' '.$members->phone;
            $members = ArrayHelper::map($members, "member_id",     function ($model) {
                return $model['first_name'] . '   ' . $model['last_name'] . '   email:' . $model['email'];
            });
        } else {
            if (Yii::$app->user->identity->organization_ids)
                $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));

            foreach ($apt_ids as  $id) {
                $members = Memberorganization::find()->select('o_member_organization.member_id, member.email, member_profile.last_name,member_profile.first_name')
                    ->joinWith('member')->joinWith('memberprofile')->where(['organization_id' => $id])->all();
                $members = ArrayHelper::map($members, "member_id",     function ($model) {
                    return $model['first_name'] . '   ' . $model['last_name'] . '   email:' . $model['member_id'];
                });
            }
        }
        return $members;
    }
}

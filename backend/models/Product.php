<?php

namespace backend\models;

use Yii;
use Yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
//use backend\models\Productcategory;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property integer $organization_id
 * @property string $product_name
 * @property integer $category_id
 * @property string $brand
 * @property string $manufacturer
 * @property string $UOM
 * @property integer $part_num
 * @property integer $model_num
 * @property integer $is_public
 * @property string $product_desc
 * @property string $product_image
 * @property string $product_thumbnail
 * @property string $instruction
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $end_date
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imageFile;
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'category_id', 'part_num', 'model_num', 'is_public', 'create_time', 'update_time', 'end_date','boxmodel_id'], 'integer'],
            [['product_name'], 'required'],
            [['product_name'], 'string', 'max' => 60],
            [['brand', 'manufacturer', 'UOM'], 'string', 'max' => 20],
            [['product_desc'], 'string', 'max' => 120],
            [['product_image', 'product_thumbnail'], 'safe'],
            [['instruction'], 'string', 'max' => 255],
            //[['file'], 'file', 'skipOnEmpty' => true],
            //[['file'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png'],
            //[['file'], 'file', 'maxFiles'=>4],
            //[['file'], 'safe'],
            [['imageFile'], 'file',],
        ];
      }
      
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'organization_id' => 'Organization',
            'boxmodel_id'=> 'Box Model Size',
            'product_name' => 'Product Name',
            'category_id' => 'Product Category',
            'brand' => 'Brand',
            'manufacturer' => 'Manufacturer',
            'UOM' => 'Uom',
            'part_num' => 'Part Num',
            'model_num' => 'Model Num',
            'is_public' => 'Is Public',
            'product_desc' => 'Product Desc',
            'product_image' => 'Product Image',
            'product_thumbnail' => 'Product Thumbnail',
            'instruction' => 'instruction',
            'file' => 'Photo',
       //     'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'end_date' => 'End Date',
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
    }
    public function getBoxmodel()
    {
        return $this->hasOne(Cabinetboxmodel::className(), ['model_id' => 'boxmodel_id']);
    }

   

    public function getProductcategory()
    {
        return $this->hasOne(ProductCategory::className(), ['product_cate_id' => 'category_id']);
    }

    public static  function  getBoxmodelname()
    {
     
      $boxmodel= [];
     
        $boxmodel = Cabinetboxmodel::find()->all();
        $boxmodel = ArrayHelper::map($boxmodel, 'model_id', 'model_name');
      
     
      return  $boxmodel;
    }

    public static  function  getProductcategoryName()
    {
      //  $productcategoy = ProductCategory::find()->all();
      //  $productcategoy = ArrayHelper::map($productcategoy, 'product_cate_id', 'product_cate_name');
      //  return $productcategoy;
      $productcategory= [];
      if(strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin')
      {
        $productcategory = ProductCategory::find()->all();
        $productcategory = ArrayHelper::map($productcategory, 'product_cate_id', 'product_cate_name');
      }
      else
      {
        
          if(Yii::$app->user->identity->organization_ids)
          $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));

           foreach ($apt_ids as $key=>$id)
              {
                  $productcategory = ProductCategory::find()->where(['organization_id'=>$id])->all();
                  $productcategory = ArrayHelper::map($productcategory, 'product_cate_id', 'product_cate_name');
              }
      }
      return  $productcategory;
    }

    public static  function  getOrganizationName()
    {
      //  $organization = Organization::find()->all();
      //  $organization = ArrayHelper::map($organization, 'organization_id', 'organization_name');
      //  return $organization;
      $organizations = [];
      if(strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin')
      {
          $organizations = Organization::find()->all();
          $organizations = ArrayHelper::map($organizations, 'organization_id', 'organization_name');
      }
      else
      {
          if(Yii::$app->user->identity->organization_ids)
          {
              $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));
              foreach ($apt_ids as $key=>$id)
              {
                  $organizations[$id] = Organization::findOne(['organization_id'=>$id])->organization_name;
              }
          }
      }
      return $organizations;
    }
}

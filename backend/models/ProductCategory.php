<?php

namespace backend\models;

use Yii;
use Yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product_category".
 *
 * @property string $product_cate_id 种类ID
 * @property string $product_cate_name 种类名字
 * @property string $product cate_desc 种类描叙
 * @property string $create_time 穿建时间
 * @property int $update_time 更新时间
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['product_cate_name'], 'string', 'max' => 60],
            [['organization_id'], 'required'],
            [['product_cate_desc'], 'string', 'max' => 120],
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
            'product_cate_id' => Yii::t('app', 'Category ID'),
            'product_cate_name' => Yii::t('app', 'Name'),
            'product_cate_desc' => Yii::t('app', 'Description'),
            'organization_id' => Yii::t('app', 'Company'),
            'create_time' => Yii::t('app', 'Created'),
            'update_time' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProductCategoryQuery the active query used by this AR class.
     
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }*/


    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
    }

    public static  function  getOrganizationName()
    {
        $organization = Organization::find()->all();
        $organization = ArrayHelper::map($organization, 'organization_id', 'organization_name');
        return $organization;
    }
}

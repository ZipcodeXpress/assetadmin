<?php

namespace backend\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "o_product_auth".
 *
 * @property integer $product_id
 * @property integer $member_id
 * @property integer $auth_code
 */
class ProductAuth extends \yii\db\ActiveRecord
{
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_product_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'member_id','organization_id'], 'required'],
            [['product_id', 'member_id', 'organization_id','auth_code', 'cancel_time', 'created_time','approve_time','approve_status',], 'integer'],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_time',
                'updatedAtAttribute' => 'created_time',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product',
            'organization_id' => 'Organization',
            'member_id' => 'Member',
            'auth_code' => 'Status',
            'approve_status' => 'Approve Status',
            'cancel_time' => 'Cancel Time',
            'created_time' => 'Created Time',
            'approve_time' => 'Approve Time',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(), ['memeber_id' => 'member_id']);
    }
    public function getProfile() {
        return $this->hasOne(Memberprofile::className(), ['member_id' => 'member_id']); 
    }

  /*  public static  function  getProductName()
    {
        $product = Product::find()->all();
        $product = ArrayHelper::map($product, 'product_id', 'product_name');
        return $product;
    }

    public static  function  getMemberemail()
    {
        $member = Membert::find()->all();
        $memberemail = ArrayHelper::map($member, 'member_id', 'member_email');
        return $memberemail;
    }*/
}


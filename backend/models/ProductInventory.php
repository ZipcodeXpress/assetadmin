<?php

namespace backend\models;
use Yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "product_inventory".
 *
 * @property string $product_inventory_id
 * @property integer $product_id
 * @property integer $cabinet_id
 * @property integer $organization_id
 * @property integer $member_id
 * @property integer $col
 * @property integer $row
 * @property string $rfid
 * @property integer $product_status_code
 * @property string $product_service_type
 * @property string $reg_date
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $end_time
 */
class ProductInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'cabinet_id', 'organization_id', 'member_id', 'box_id',  'product_status_code', 'create_time', 'update_time', 'end_time'], 'integer'],
            [['reg_date'], 'safe'],
            [['rfid'], 'string', 'max' => 16],
            [['product_service_type'], 'string', 'max' => 4],
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
            'product_inventory_id' => 'Product Inventory ID',
            'product_id' => 'Product',
            'cabinet_id' => 'Cabinet ID',
            'organization_id' => 'Company',
            'member_id' => 'Member ID',
           'box_id' => 'Box ID',
           'colunm' => 'Column',
            'row' => 'Row',
            'rfid' => 'Rfid',
            'product_status_code' => 'Status Code',
            'product_service_type' => 'Product Service Type',
            'reg_date' => 'Reg Date',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'end_time' => 'End Time',
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
    }
    public function getBox()
    {
        return $this->hasOne(Cabinetbox::className(), ['box_id' => 'box_id']);
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id' => 'member_id']);
    }
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }

    public function getProductRental() {
        return $this->hasMany(ProductRental::className(), ['product_inventory_id' => 'product_inventory_id']);
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_rental".
 *
 * @property integer $rental_id
 * @property integer $organization_id
 * @property integer $cabinet_id
 * @property integer $product_inventory_id
 * @property string $rfid
 * @property integer $member_id
 * @property string $pickup_code
 * @property integer $reserve_time
 * @property integer $expire_time
 * @property integer $rental_time
 * @property string $rental_status_code
 * @property double $applied_deposit
 * @property double $applied_daily_fee
 * @property double $applied_sale_amt
 * @property integer $applied_free_days
 * @property integer $return_locker_id
 * @property integer $return_time
 * @property integer $return_elapsed_days
 * @property double $total_charged_amt
 * @property integer $Is_comment
 * @property integer $Is_delete
 */
class ProductRental extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_rental';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'product_id','cabinet_id', 'product_inventory_id', 'member_id', 'reserve_time', 'expire_time', 'rental_time', 'applied_free_days', 'return_locker_id', 'return_time', 'return_elapsed_days', 'Is_comment', 'Is_delete'], 'integer'],
            [['applied_deposit', 'applied_daily_fee', 'applied_sale_amt', 'total_charged_amt'], 'number'],
            [['rfid'], 'string', 'max' => 32],
            [['pickup_code'], 'string', 'max' => 12],
            [['rental_status_code'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rental_id' => 'Rental ID',
            'organization_id' => 'Organization ID',
            'product_id' => 'Product',
            'cabinet_id' => 'Cabinet ID',
            'product_inventory_id' => 'Product Inventory ID',
            'rfid' => 'Rfid',
            'member_id' => 'Member ID',
            'pickup_code' => 'Pickup Code',
            'reserve_time' => 'Reserve Time',
            'expire_time' => 'Expire Time',
            'rental_time' => 'Rental Time',
            'rental_status_code' => 'Rental Status Code',
            'applied_deposit' => 'Applied Deposit',
            'applied_daily_fee' => 'Applied Daily Fee',
            'applied_sale_amt' => 'Applied Sale Amt',
            'applied_free_days' => 'Applied Free Days',
            'return_locker_id' => 'Return Locker ID',
            'return_time' => 'Return Time',
            'return_elapsed_days' => 'Return Elapsed Days',
            'total_charged_amt' => 'Total Charged Amt',
            'Is_comment' => 'Is Comment',
            'Is_delete' => 'Is Delete',
        ];
    }




public function getMember()
{
    return $this->hasOne(Member::className(), ['member_id' => 'member_id']);
}
public function getOrganization()
{
    return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
}

public function getProductInventory()
{
    return $this->hasOne(ProductInventory::className(),  ['product_inventory_id' => 'product_inventory_id']);
}


}
<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "o_store".
 *
 * @property string $store_id
 * @property integer $cabinet_id
 * @property integer $box_id
 * @property integer $from_member_id
 * @property integer $store_time
 * @property string $tracking_no
 * @property integer $to_member_id
 * @property string $to_phone
 * @property string $pick_code
 * @property integer $pick_expire
 * @property string $pick_fee
 * @property integer $pick_time
 * @property string $pick_with
 * @property integer $clean_time
 * @property integer $create_time
 */
class Store extends \yii\db\ActiveRecord
{
    public $company_name;
    public $model_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cabinet_id', 'box_id', 'from_member_id', 'to_phone', 'pick_code', 'pick_expire',], 'required'],
            [['cabinet_id', 'box_id', 'from_member_id', 'store_time', 'to_member_id', 'pick_expire', 'pick_time', 'clean_time', 'create_time'], 'integer'],
            [['pick_fee'], 'number'],
            [['pick_with'], 'string'],
            [['tracking_no'], 'string', 'max' => 512],
            [['to_phone', 'pick_code'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'store_id' => 'Store ID',
            'cabinet_id' => 'Locker ID',
            'box_id' => 'Box ID',
            'from_member_id' => 'From Member ID',
            'store_time' => 'Store Time',
            'tracking_no' => 'Tracking No',
            'to_member_id' => 'To Member ID',
            'to_phone' => 'To Phone',
            'pick_code' => 'Pick Code',
            'pick_expire' => 'Pick Expire',
            'pick_fee' => 'Pick Fee',
            'pick_time' => 'Pick Time',
            'pick_with' => 'Pick With',
            'clean_time' => 'Clean Time',
            'create_time' => 'Create Time',
        ];
    }
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id'=>'from_member_id']);
    }
    public function getToMember()
    {
        return $this->hasOne(Member::className(), ['member_id'=>'to_member_id']);
    }
    public function getCourier()
    {
         return $this->hasOne(Courier::className(), ['courier_id'=>'courier_id']);
    }
    public function getBox()
    {
        return $this->hasOne(Cabinetbox::className(), ['box_id'=>'box_id']);
    }
}

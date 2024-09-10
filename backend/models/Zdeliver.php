<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "z_deliver".
 *
 * @property integer $deliver_id
 * @property integer $cargo_type_id
 * @property string $cargo_worth
 * @property double $cargo_weight
 * @property integer $box_model_id
 * @property integer $from_member_id
 * @property integer $from_cabinet_id
 * @property integer $from_box_id
 * @property integer $to_member_id
 * @property string $to_phone
 * @property string $to_name
 * @property integer $to_cabinet_id
 * @property integer $to_box_id
 * @property integer $deliver_photo_group_id
 * @property double $dist
 * @property string $fee_total
 * @property string $remark
 * @property string $cargo_code
 * @property string $pick_code
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $cargo_status
 * @property integer $status
 * @property integer $courier_id
 */
class Zdeliver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_deliver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cargo_type_id', 'cargo_worth', 'cargo_weight', 'box_model_id', 'from_member_id', 'from_cabinet_id', 'from_box_id', 'to_phone', 'to_name', 'to_cabinet_id', 'to_box_id', 'fee_total', 'cargo_code', 'pick_code', ], 'required'],
            [['cargo_type_id', 'box_model_id', 'from_member_id', 'from_cabinet_id', 'from_box_id', 'to_member_id', 'to_cabinet_id', 'to_box_id', 'deliver_photo_group_id', 'create_time', 'update_time',  'status', 'courier_id'], 'integer'],
            [['cargo_worth', 'cargo_weight', 'dist', 'fee_total'], 'number'],
            [['to_phone', 'to_name', 'cargo_code', 'pick_code'], 'string', 'max' => 32],
            [['remark'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deliver_id' => 'Deliver ID',
            'cargo_type_id' => 'Cargo Type ID',
            'cargo_worth' => 'Cargo Worth',
            'cargo_weight' => 'Cargo Weight',
            'box_model_id' => 'Box Model ID',
            'from_member_id' => 'From Member ID',
            'from_cabinet_id' => 'From Locker ID',
            'from_box_id' => 'From Box ID',
            'to_member_id' => 'To Member ID',
            'to_phone' => 'To Phone',
            'to_name' => 'To Name',
            'to_cabinet_id' => 'To Locker ID',
            'to_box_id' => 'To Box ID',
            'deliver_photo_group_id' => 'Deliver Photo Group ID',
            'dist' => 'Dist',
            'fee_total' => 'Fee Total',
            'remark' => 'Remark',
            'cargo_code' => 'Cargo Code',
            'pick_code' => 'Pick Code',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
            'courier_id' => 'Courier ID',
        ];
    }
    
    public function getFromMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'from_member_id'])->from(['fromMember' => Member::tableName()]);
    }
    public function getToMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'to_member_id'])->from(['toMember' => Member::tableName()]);
    }
    public function getCourier() {
        return $this->hasOne(Member::className(), ['member_id'=>'courier_id']);
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "z_courier_order".
 *
 * @property integer $order_id
 * @property integer $deliver_id
 * @property integer $courier_id
 * @property integer $create_time
 * @property integer $fetch_time
 * @property integer $fetch_photo_group_id
 * @property integer $status
 * @property string $cancel_reason
 * @property string $fee_total
 * @property string $user_rating
 * @property string $remark
 */
class Zcourierorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_courier_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deliver_id', 'courier_id', ], 'required'],
            [['deliver_id', 'courier_id', 'create_time', 'fetch_time', 'fetch_photo_group_id', 'status', ], 'integer'],
            [['fee_total'], 'number'],
            [['cancel_reason', 'remark'], 'string', 'max' => 512],
            [['user_rating'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'deliver_id' => 'Deliver ID',
            'courier_id' => 'Courier ID',
            'create_time' => 'Create Time',
            'fetch_time' => 'Fetch Time',
            'fetch_photo_group_id' => 'Fetch Photo Group ID',
            'status' => 'Status',
            'cancel_reason' => 'Cancel Reason',
            'fee_total' => 'Fee Total',
            'user_rating' => 'User Rating',
            'remark' => 'Remark',
        ];
    }
    public function getMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'courier_id']);
    }
}

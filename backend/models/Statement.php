<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "statement".
 *
 * @property integer $statement_id
 * @property integer $member_id
 * @property string $statement_type
 * @property string $statement_desc
 * @property string $amount
 * @property string $money
 * @property string $frozen_money
 * @property string $ubi
 * @property string $channel
 * @property string $extra
 * @property integer $order_id
 * @property integer $order_payment_id
 * @property integer $create_time
 */
class Statement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'order_id', 'order_payment_id', 'create_time'], 'integer'],
            [['amount', 'money', 'frozen_money', 'ubi'], 'number'],
            [['statement_type'], 'string', 'max' => 20],
            [['statement_desc', 'channel'], 'string', 'max' => 255],
            [['extra'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'statement_id' => 'Statement ID',
            'member_id' => 'Member ID',
            'statement_type' => 'Statement Type',
            'statement_desc' => 'Statement Desc',
            'amount' => 'Amount',
            'money' => 'Money',
            'frozen_money' => 'Frozen Money',
            'ubi' => 'Ubi',
            'channel' => 'Channel',
            'extra' => 'Extra',
            'order_id' => 'Order ID',
            'order_payment_id' => 'Order Payment ID',
            'create_time' => 'Create Time',
        ];
    }
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id'=>'member_id']);
    }
}

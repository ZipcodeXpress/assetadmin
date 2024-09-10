<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "z_courier".
 *
 * @property integer $courier_id
 * @property integer $credit_rating
 * @property integer $grade
 * @property double $user_rating
 * @property integer $total_orders
 * @property integer $bad_orders
 * @property integer $is_signed
 */
class Zcourier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_courier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['credit_rating', 'grade', 'total_orders', 'bad_orders', 'is_signed'], 'integer'],
            [['user_rating'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courier_id' => 'Courier ID',
            'credit_rating' => 'Credit Rating',
            'grade' => 'Grade',
            'user_rating' => 'User Rating',
            'total_orders' => 'Total Orders',
            'bad_orders' => 'Bad Orders',
            'is_signed' => 'Is Signed',
        ];
    }
    
    public function getMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'courier_id']);
    }
}

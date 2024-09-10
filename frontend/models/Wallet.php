<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "wallet".
 *
 * @property integer $member_id
 * @property string $money
 * @property string $frozen_money
 * @property string $ubi
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wallet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id'], 'required'],
            [['member_id'], 'integer'],
            [['money', 'frozen_money', 'ubi'], 'number'],
            [['member_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'money' => 'Money',
            'frozen_money' => 'Frozen Money',
            'ubi' => 'Ubi',
        ];
    }
    public function getMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'member_id']);
    }
}

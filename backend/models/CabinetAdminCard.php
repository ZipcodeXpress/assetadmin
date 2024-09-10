<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cabinet_admin_card".
 *
 * @property int $cardId
 * @property int $zp_admin_id zp_admin后台管理员id
 * @property string $zp_admin_name
 * @property string $zp_admin_role
 * @property int $cabinet_id 快递柜ID
 * @property string $rfid 卡号
 * @property int $status 0不可用，1可用
 */
class CabinetAdminCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_admin_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id','zp_admin_id', 'cabinet_id', 'status'], 'integer'],
            [['zp_admin_id', 'cabinet_id', 'rfid'], 'required'],
            [['zp_admin_name', 'zp_admin_role', 'rfid'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_id' => 'Card ID',
            'zp_admin_id' => 'Zp Admin ID',
            'zp_admin_name' => 'Zp Admin Name',
            'zp_admin_role' => 'Zp Admin Role',
            'cabinet_id' => 'Locker ID',
            'rfid' => 'Rfid',
            'status' => 'Status',
        ];
    }
}

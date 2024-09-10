<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use Yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "o_courier".
 *
 * @property string $courier_id
 * @property integer $company_id
 * @property string $courier_name
 * @property string $card_code
 * @property integer $status
 * @property integer $create_time
 */
class Courier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_courier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'courier_name', 'card_code', 'email',], 'required',],
            [['company_id', 'status', 'create_time'], 'integer'],
            [['courier_name', 'card_code', 'email', 'phone'], 'string', 'max' => 512],
        ];
    }
//     public function scenarios()
//     {
//        return [
//             'create' => ['company_id','courier_name', 'card_code', 'email','status', ],
//             'update' => ['company_id','courier_name', 'card_code', 'email','status', ],
//            ];
//     }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courier_id' => 'Courier ID',
            'company_id' => 'Company',
            'courier_name' => 'Courier Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'card_code' => 'Access Code',
            'status' => 'Status(0 Normal ；1 Blocked)',
            'create_time' => 'Create Time',
        ];
    }
    
    public function getCompany()
    {
        return $this->hasOne(Couriercompany::className(), ['company_id' => 'company_id']);
    }
    
    public static  function  getCompanyName()
    {
        $company = Couriercompany::find()->all();
        $company = ArrayHelper::map($company, 'company_id', 'company_name');
        return $company;
    }
}

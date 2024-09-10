<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "o_courier_company".
 *
 * @property string $company_id
 * @property string $company_name
 * @property string $logo
 * @property string $address
 * @property string $contact_name
 * @property string $contact_phone
 * @property integer $contract_begin
 * @property integer $contract_end
 * @property integer $create_time
 */
class Couriercompany extends \yii\db\ActiveRecord
{
    public $longitude;
    public $latitude;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_courier_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'address', 'contact_name','contact_phone'], 'required'],
            [['company_name'], 'unique','message'=>'{attribute} already exist!'],
            [[ 'create_time'], 'integer'],//'contract_begin', 'contract_end',
            [['company_name', 'logo', 'address', 'contact_name'], 'string', 'max' => 512],
            [['contact_phone'], 'string', 'max' => 32],
//             ['contract_begin' ,  'filter', 'filter' => function(){
//                 return strtotime($this->contract_begin);
//             }],
//             ['contract_end' ,  'filter', 'filter' => function(){
//                 return strtotime($this->contract_end);
//             }],
        ];
    }
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
            'company_id' => 'Company ID',
            'company_name' => 'Company Name',
            'logo' => 'Logo',
            'address' => 'Address',
            'contact_name' => 'Contact',
            'contact_phone' => 'Phone',
            'contract_begin' => 'Contract Begin',
            'contract_end' => 'Contract End',
            'create_time' => 'Create Time',
        ];
    }
}

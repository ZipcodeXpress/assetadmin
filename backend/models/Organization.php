<?php

namespace backend\models;

use Yii;
use Yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "o_organization".
 *
 * @property string $organization_id
 * @property string $organization_name
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $zipcode
 * @property double $latitude
 * @property double $longitude
 * @property integer $contract_begin
 * @property integer $contract_end
 * @property string $price
 * @property integer $create_time
 */
class Organization extends \yii\db\ActiveRecord
{
    public $sign_up_fee = 0;
    public $sign_fee_pay_online = 0;
    public $monthly_fee=0;
    public $month_fee_pay_online = 1;
    public $begin_time;
    public $end_time;
    
    public $box_penalty;
    
    public $amount;
    public $pay_online;
    public $grace_day;
    
    public $box_models;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_name', 'address', 'contract_begin', 'contract_end',], 'required'],
            [['organization_name'], 'unique','message'=>'{attribute} already exist!'],
            [['latitude', 'longitude',], 'number'],
            [[ 'create_time'], 'integer'],//'contract_begin', 'contract_end',
            [['organization_name', 'state', 'city'], 'string', 'max' => 512],
            [['address'], 'string', 'max' => 256],
            [['zipcode'], 'string', 'max' => 16],
            ['contract_begin' ,  'filter', 'filter' => function(){
                return strtotime($this->contract_begin);
            }],
            ['contract_end' ,  'filter', 'filter' => function(){
                return strtotime($this->contract_end);
            }],
            [[ 'sign_up_fee','sign_fee_pay_online','monthly_fee','month_fee_pay_online','amount','pay_online','grace_day','box_penalty'], 'safe']
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
            'organization_id' => 'Organization ID',
            'organization_name' => 'Organization Name',
            'state' => 'State',
            'city' => 'City',
            'address' => 'Address',
            'zipcode' => 'Zipcode',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'contract_begin' => 'Contract Begin',
            'contract_end' => 'Contract End',
            'price' => 'Price',
            'create_time' => 'Create Time',
            'sign_up_fee' => 'Sign Up Fee',
            'sign_fee_pay_online' => 'Pay Online',
            'monthly_fee'=>'Monthly Fee',
            'month_fee_pay_online' => 'Pay Online',
        ];
    }
    public function getBuildings() {
        return $this->hasMany(Building::className(), ['organization_id'=>'organization_id']);
    }
}

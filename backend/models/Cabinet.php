<?php

namespace backend\models;

use Yii;
use Yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cabinet".
 *
 * @property integer $cabinet_id
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $zipcode
 * @property double $latitude
 * @property double $longitude
 * @property string $api_key
 * @property string $api_secret
 * @property string $service_type
 * @property integer $create_time
 */
class Cabinet extends \yii\db\ActiveRecord
{
    //public $address;
    //public $longitude;
    //public $latitude;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'city',  'address', 'zipcode','latitude','longitude','service_type','api_key','api_secret'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['service_type','address_url'], 'string'],
            [['create_time'], 'integer'],
            [['state', 'city', 'api_key', 'api_secret'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 256],
            [['zipcode'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cabinet_id' => 'Locker ID',
            'state' => 'State',
            'city' => 'City',
            'address' => 'Address',
            'zipcode' => 'Zipcode',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'api_key' => 'Api Key',
            'api_secret' => 'Api Secret',
            'service_type' => 'Service Type',
            'create_time' => 'Create Time',
            'address_url'=>'Address Url'
        ];
    }
//     public function behaviors()
//     {
//         return [
//             [
//                 'class' => TimestampBehavior::className(),
//                 'createdAtAttribute' => 'create_time',
//                 'updatedAtAttribute' => 'create_time',
//             ],
//         ];
//     }
    /**
     * @inheritdoc
     * @return CabinetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CabinetQuery(get_called_class());
    }
}

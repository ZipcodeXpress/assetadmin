<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "member_address".
 *
 * @property integer $address_id
 * @property integer $member_id
 * @property string $first_name
 * @property string $last_name
 * @property string $state
 * @property string $city
 * @property string $address
 * @property double $longitude
 * @property double $latitude
 * @property string $zipcode
 * @property integer $create_time
 */
class Memberaddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'address'], 'required'],
            [['member_id', 'create_time'], 'integer'],
            [['longitude', 'latitude'], 'number'],
            [['first_name', 'last_name', 'state', 'city'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 256],
            [['zipcode'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_id' => 'Address ID',
            'member_id' => 'Member ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'state' => 'State',
            'city' => 'City',
            'address' => 'Address',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'zipcode' => 'Zipcode',
            'create_time' => 'Create Time',
        ];
    }
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id' => 'member_id']);
    }
}

<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "member_profile".
 *
 * @property integer $member_id
 * @property string $nick_name
 * @property string $first_name
 * @property string $last_name
 * @property string $addressline1
 * @property string $addressline2
 * @property string $city
 * @property string $state
 * @property integer $zipcode
 * @property string $phone
 * @property string $birth
 * @property integer $sex
 * @property string $avatar
 * @property integer $profile_id
 * @property integer $create_time
 */
class Memberprofile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id'], 'required'],
            [['member_id', 'zipcode', 'sex', 'profile_id', 'create_time'], 'integer'],
            [['birth'], 'safe'],
            [['nick_name', 'first_name', 'last_name', 'addressline1', 'addressline2'], 'string', 'max' => 255],
            [['city', 'state'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'nick_name' => 'Nick Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'addressline1' => 'Addressline1',
            'addressline2' => 'Addressline2',
            'city' => 'City',
            'state' => 'State',
            'zipcode' => 'Zipcode',
            'phone' => 'Phone',
            'birth' => 'Birth',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'profile_id' => 'Profile ID',
            'create_time' => 'Create Time',
        ];
    }
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id' => 'member_id']);
    }
}

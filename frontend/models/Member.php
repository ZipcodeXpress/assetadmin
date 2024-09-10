<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $member_id
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property integer $salt
 * @property integer $register_time
 * @property integer $lastlogin_time
 * @property string $last_ip
 * @property integer $status
 * @property integer $c_status
 * @property integer $is_email_verified
 * @property integer $is_profile_completed
 * @property integer $has_credit_card
 * @property integer $cabinet_id
 * @property string $service_mode
 */
class Member extends \yii\db\ActiveRecord
{
    public $file;
    public $organization_id;
    public $unit_name;
    public $first_name;
    public $last_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salt', 'register_time', 'lastlogin_time', 'status', 'c_status', 'is_email_verified', 'is_profile_completed', 'has_credit_card', 'cabinet_id'], 'integer'],
            [['service_mode'], 'string'],
            [['email'], 'string', 'max' => 255],
            [['phone', 'password', 'last_ip'], 'string', 'max' => 32],
            [['file'], 'file', ],
            [['unit_name'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'salt' => 'Salt',
            'register_time' => 'Register Time',
            'lastlogin_time' => 'Lastlogin Time',
            'last_ip' => 'Last Ip',
            'status' => 'Status',
            'c_status' => 'C Status',
            'is_email_verified' => 'Is Email Verified',
            'is_profile_completed' => 'Is Profile Completed',
            'has_credit_card' => 'CreditCard',
            'cabinet_id' => 'Cabinet ID',
            'service_mode' => 'Service Mode',
        ];
    }
    
    public function getAddress() {
         return $this->hasMany(Memberaddress::className(), ['member_id' => 'member_id']);
    }
    public function getProfile() {
        return $this->hasOne(Memberprofile::className(), ['member_id' => 'member_id']); 
    }
}

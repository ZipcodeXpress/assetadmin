<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use app\models\PhotoGroup;

/**
 * This is the model class for table "o_member_organization".
 *
 * @property integer $member_id
 * @property integer $organization_id
 * @property integer $building_id
 * @property integer $room_id
 * @property integer $apply_photo_group_id
 * @property integer $apply_time
 * @property integer $approve_time
 * @property integer $approve_status
 * @property integer $charge_day
 * @property string $price
 * @property string $cost
 * @property string $cost_offline
 * @property integer $status
 * @property integer $cancel_time
 * @property integer $create_time
 */
class Memberorganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_member_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'organization_id',], 'required'],
            [['member_id', 'organization_id',  'apply_photo_group_id',  'approve_status', 'charge_day', 'status', 'cancel_time', 'create_time'], 'integer'],
            [['price', 'cost', 'cost_offline'], 'number'],
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
            'member_id' => 'Member ID',
            'organization_id' => 'Organization ID',
            'building_id' => 'Building ID',
            'room_id' => 'Room ID',
            'apply_photo_group_id' => 'Apply Photo Group ID',
            'apply_time' => 'Apply Time',
            'approve_time' => 'Approve Time',
            'approve_status' => 'Approve Status',
            'charge_day' => 'Charge Day',
            'price' => 'Monthly Price',
            'cost' => 'Paid Online',
            'cost_offline' => 'Paid Offline',
            'status' => 'Status',
            'cancel_time' => 'Cancel Time',
            'create_time' => 'Create Time',
        ];
    }
    
    public function getMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'member_id']);
    }
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id'=>'organization_id']);
    }
    public function getPhoto()
    {
        return $this->hasOne(PhotoGroup::className(), ['photo_group_id'=>'apply_photo_group_id']);
    }
    public function  getUnit()
    {
        return $this->hasOne(Unit::className(), ['unit_id'=>'unit_id']);
    }
    public function  getMemberprofile()
    {   
        return $this->hasOne(Memberprofile::className(), ['member_id'=>'member_id']);
    }

    public static  function  getOrganizationName()
    {
        //$organizations = Organization::find()->all();
        //$organizations = ArrayHelper::map($organizations, 'organization_id', 'organization_name');
        //return $organizations;
        $organizations = [];
        if(strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin')
        {
            $organizations = Organization::find()->all();
            $organizations = ArrayHelper::map($organizations, 'organization_id', 'organization_name');
        }
        else
        {
            if(Yii::$app->user->identity->organization_ids)
            {
                $apt_ids = array_filter(explode(',', Yii::$app->user->identity->organization_ids));
                foreach ($apt_ids as $key=>$id)
                {
                    $organizations[$id] = Organization::findOne(['organization_id'=>$id])->organization_name;
                }
            }
        }
        return $organizations;
    }
    public static  function  getUnitName()
    {
        $units = Unit::find()->all();
        $units = ArrayHelper::map($units, 'unit_id', 'unit_name');
        return $units;
    }
    public static  function  getUnitNameByOrganizationId($organization_id)
    {
        $units = Unit::find()->where(['organization_id'=>$organization_id])->all();
        $units = ArrayHelper::map($units, 'unit_id', 'unit_name');
        return $units;
    }
}

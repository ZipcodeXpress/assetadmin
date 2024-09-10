<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use Yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "o_courier_organization".
 *
 * @property string $courier_id
 * @property integer $organization_id
 * @property integer $create_time
 */
class Courierorganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_courier_organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courier_id', 'organization_id'], 'required'],
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
            'courier_id' => 'Courier ID',
            'organization_id' => 'Organization ID',
            'create_time' => 'Create Time',
        ];
    }
    public function getCourier()
    {
        return $this->hasOne(Courier::className(), ['courier_id'=>'courier_id']);
    }
    public function getCorpcourier()
    {
        return $this->hasOne(CourierCompanyOrganization::className(), ['courier_id'=>'courier_id']);
    }
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id'=>'organization_id']);
    }
    public static  function  getCourierEmail($courierId=null)
    {
        if($courierId) {
            $courierList = Courier::find()->andWhere(['in', 'courier_id', explode(',', $courierId)])->all();
            return $courierList[0];
        }
        return false;
    }
    public static  function  getCourierEx($courierId=null)
    {
        if($courierId) {
            $courierList = Courier::find()->andWhere(['in', 'courier_id', explode(',', $courierId)])->one();
            if(empty($courierList))
            {
                return CourierCompanyOrganization::find()->joinWith("company")->andWhere(['in', 'courier_id', explode(',', $courierId)])->one();
            }
            else 
            {
                return $courierList;
            }
        }
        return false;
    }
    public static  function  getCourierName($courierId=null)
    {
        if($courierId) {
            $courierList = Courier::find()->andWhere(['in', 'courier_id', explode(',', $courierId)])->all();
        } else {
            $courierList = Courier::find()->all();
        }
        foreach($courierList as $c) {
            //$courierArr[$c['courier_id']] = $c['courier_name']. '|'.$c['email']. '|'. $c['phone']; 
            $courierArr[$c['courier_id']] = $c['courier_name']. ' | '.$c['email']. ' | '. preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $c['phone']);
        }
        //$courierArr = ArrayHelper::map($courierList, 'courier_id', 'courier_name');
        return $courierArr;
    }
    public static  function  getCourierList($courierId=null)
    {
        if($courierId) {
            $courierList = Courier::find()->andWhere(['in', 'courier_id', explode(',', $courierId)])->all();
            if(empty($courierList))
            {
                $courierList = CourierCompanyOrganization::find()->joinWith("company")->andWhere(['in', 'courier_id', explode(',', $courierId)])->all();
            }
        } else {
            $courierList = Courier::find()->all();
            if(empty($courierList))
            {
                $courierList = CourierCompanyOrganization::find()->joinWith("company")->all();
            }
        }
        foreach($courierList as $c) {
            //$courierArr[$c['courier_id']] = $c['courier_name']. '|'.$c['email']. '|'. $c['phone'];
            if(isset($c['courier_name']))
            {
                $courierArr[$c['courier_id']] = $c['courier_name']. ' | '.$c['email']. ' | '. preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $c['phone']);
            }
            else 
            {
                $courierArr[$c['courier_id']] = $c->company->company_name. ' | Corp Courier';
            }
        }
        //$courierArr = ArrayHelper::map($courierList, 'courier_id', 'courier_name');
        return $courierArr;
    }
    public static  function  getOrganizationName($organizationIds=null)
    {
        if($organizationIds) {
            $organizationList = Organization::find()->andWhere(['in', 'organization_id', explode(',', $organizationIds)])->all();
        } else {
            $organizationList = Organization::find()->all();
        }
        $organizationArr = ArrayHelper::map($organizationList, 'organization_id', 'organization_name');
        return $organizationArr;
    }
}

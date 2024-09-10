<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use Yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "o_organization_cabinet".
 *
 * @property integer $organization_id
 * @property integer $cabinet_id
 * @property integer $create_time
 */
class OrganizationCabinet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_organization_cabinet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'cabinet_id', ], 'required'],
            [['organization_id', 'cabinet_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organization_id' => 'Organization ID',
            'cabinet_id' => 'Locker ID',
            'create_time' => 'Create Time',
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
    
    
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id'=>'organization_id']);
    }
    public function getCabinet() {
        return $this->hasOne(Cabinet::className(), ['cabinet_id'=>'cabinet_id']);
    }
    public static  function  getOrganizationName()
    {
        $organization = Organization::find()->all();
        $organization = ArrayHelper::map($organization, 'organization_id', 'organization_name');
        return $organization;
    }
}

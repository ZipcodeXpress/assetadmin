<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "o_building".
 *
 * @property string $building_id
 * @property string $building_name
 * @property integer $organization_id
 * @property integer $create_time
 */
class Building extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_building';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['building_name', 'organization_id'], 'required'],
            [['organization_id', 'create_time'], 'integer'],
            [['building_name'], 'string', 'max' => 256],
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
            'building_id' => 'Building ID',
            'building_name' => 'Building Name',
            'organization_id' => 'Organization_ID',
            'create_time' => 'Create Time',
        ];
    }
    
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
    }
    
    public static  function  getOrganizationName()
    {
        $company = Organization::find()->all();
        $company = ArrayHelper::map($company, 'organization_id', 'organization_name');
        return $company;
    }
}

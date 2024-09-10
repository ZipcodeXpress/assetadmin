<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "o_unit".
 *
 * @property string $unit_id
 * @property string $unit_name
 * @property integer $organization_id
 * @property integer $create_time
 */
class Unit extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_unit';
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
    public function rules()
    {
        return [
            [['unit_name', 'organization_id'], 'required'],
            [['organization_id', 'create_time'], 'integer'],
            [['unit_name'], 'string', 'max' => 256],
            [['file'], 'file', ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Unit ID',
            'unit_name' => 'Business Unit',
            'organization_id' => 'Organization ID',
            'create_time' => 'Create Time',
        ];
    }
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['organization_id' => 'organization_id']);
    }
    
    public static  function  getOrganizationName()
    {
        $organization = Organization::find()->all();
        $organization = ArrayHelper::map($organization, 'organization_id', 'organization_name');
        return $organization;
    }
}

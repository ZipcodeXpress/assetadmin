<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "o_room".
 *
 * @property string $room_id
 * @property string $room_name
 * @property integer $building_id
 * @property string $floor
 * @property string $unit
 * @property integer $create_time
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_name', 'building_id',], 'required'],
            [['building_id', 'create_time'], 'integer'],
            [['room_name'], 'string', 'max' => 256],
            [['floor', 'unit'], 'string', 'max' => 10],
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
            'room_id' => 'Room ID',
            'room_name' => 'Room Name',
            'building_id' => 'Building ID',
            'floor' => 'Floor',
            'unit' => 'Unit',
            'create_time' => 'Create Time',
        ];
    }
    
    public function getBuilding()
    {
        return $this->hasOne(Building::className(), ['building_id' => 'building_id']);
    }
    public static function getBuildingName()
    {
        $building = Building::find()->all();
        $building = ArrayHelper::map($building, 'building_id', 'building_name');
        return $building;
    }
}

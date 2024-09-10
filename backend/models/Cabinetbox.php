<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cabinet_box".
 *
 * @property integer $box_id
 * @property integer $box_model_id
 * @property integer $cabinet_id
 * @property integer $body_id
 * @property integer $row
 * @property integer $column
 * @property integer $addr
 * @property integer $status
 * @property integer $blocked
 * @property integer $update_time
 * @property integer $create_time
 */
class Cabinetbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_box';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['box_model_id', 'cabinet_id', 'body_id', 'row', 'column', 'addr',], 'required'],
            [['box_model_id', 'cabinet_id', 'body_id', 'row', 'column', 'addr', 'status', 'blocked', 'update_time', 'create_time'], 'integer'],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'box_id' => 'Box ID',
            'box_model_id' => 'Box Model Name',
            'cabinet_id' => 'Locker ID',
            'body_id' => 'Body ID',
            'row' => 'Row',
            'column' => 'Colnum',
            'addr' => 'Address',
            'status' => 'Status',
            'blocked' => 'Blocked',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @inheritdoc
     * @return CabinetboxQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CabinetboxQuery(get_called_class());
    }
    
    public function getBoxmodel() 
    {
        return $this->hasOne(Cabinetboxmodel::className(),['model_id'=>'box_model_id']);
    }
    public function getBodyname()
    {
        return $this->hasOne(Cabinetbody::className(),['body_id'=>'body_id']);
    }
}

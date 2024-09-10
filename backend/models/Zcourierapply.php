<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "z_courier_apply".
 *
 * @property integer $apply_id
 * @property integer $courier_id
 * @property integer $apply_time
 * @property integer $apply_photo_group_id
 * @property integer $process_time
 * @property integer $process_result
 * @property integer $process_by
 * @property string $remark
 */
class Zcourierapply extends \yii\db\ActiveRecord
{
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_courier_apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courier_id', 'process_result'], 'required'],
            [['courier_id', 'apply_time',  'process_result', 'process_by'], 'integer'],
            [['remark'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apply_id' => 'Apply ID',
            'courier_id' => 'Courier ID',
            'apply_time' => 'Apply Time',
            'process_time' => 'Process Time',
            'process_result' => 'Process Result',
            'process_by' => 'Process By',
            'remark' => 'Remark',
        ];
    }
    public function getMember() {
        return $this->hasOne(Member::className(), ['member_id'=>'courier_id']);
    }
    public function getProcessMember() {
        return $this->hasOne(User::className(), ['id'=>'process_by']);
    }
}

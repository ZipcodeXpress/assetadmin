<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "z_deliver_trace".
 *
 * @property integer $trace_id
 * @property integer $deliver_id
 * @property integer $create_time
 * @property integer $member_id
 * @property string $trace
 * @property string $desc
 */
class Zdelivertrace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'z_deliver_trace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deliver_id',  'trace'], 'required'],
            [['deliver_id', 'create_time'],'integer'],
            [['trace', 'desc'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trace_id' => 'Trace ID',
            'deliver_id' => 'Deliver ID',
            'create_time' => 'Create Time',
            'trace' => 'Trace',
            'desc' => 'Desc',
        ];
    }
}

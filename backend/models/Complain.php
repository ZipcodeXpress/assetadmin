<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "complain".
 *
 * @property integer $complain_id
 * @property integer $member_id
 * @property integer $complain_photo_group_id
 * @property string $complain_content
 * @property integer $process_status
 * @property integer $process_time
 * @property integer $process_by
 * @property string $process_remark
 * @property string $order_type
 * @property integer $order_id
 * @property integer $create_time
 */
class Complain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'create_time'], 'required'],
            [['member_id', 'complain_photo_group_id', 'process_status', 'process_time', 'process_by', 'order_id', 'create_time'], 'integer'],
            [['complain_content', 'order_type'], 'string'],
            [['process_remark'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'complain_id' => 'Complain ID',
            'member_id' => 'Member ID',
            'complain_photo_group_id' => 'Complain Photo Group ID',
            'complain_content' => 'Complain Content',
            'process_status' => 'Process Status',
            'process_time' => 'Process Time',
            'process_by' => 'Process By',
            'process_remark' => 'Process Remark',
            'order_type' => 'Order Type',
            'order_id' => 'Order ID',
            'create_time' => 'Create Time',
        ];
    }
}

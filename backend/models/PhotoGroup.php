<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photo_group".
 *
 * @property int $photo_group_id
 * @property string $photos 多图片id字符串拼接
 * @property int $create_time
 * @property int $member_id
 */
class PhotoGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['photos', 'create_time', 'member_id'], 'required'],
            [['photos'], 'string'],
            [['create_time', 'member_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'photo_group_id' => 'Photo Group ID',
            'photos' => 'Photos',
            'create_time' => 'Create Time',
            'member_id' => 'Member ID',
        ];
    }
}

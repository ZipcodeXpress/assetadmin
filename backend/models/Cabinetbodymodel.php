<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cabinet_body_model".
 *
 * @property integer $model_id
 * @property string $model_name
 */
class Cabinetbodymodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_body_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_name'], 'required'],
            [['model_name'], 'unique','message'=>'{attribute} already exist!'],
            [['model_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'model_id' => 'Model ID',
            'model_name' => 'Model Name',
        ];
    }
}

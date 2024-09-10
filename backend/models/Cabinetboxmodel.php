<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cabinet_box_model".
 *
 * @property integer $model_id
 * @property string $model_name
 * @property double $length
 * @property double $width
 * @property double $height
 * @property integer $is_allocable
 * @property string $model_price
 */
class Cabinetboxmodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_box_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_name','length', 'width', 'height', 'model_price'], 'required'],
            [['model_name'], 'unique','message'=>'{attribute} already exist!'],
            [['length', 'width', 'height', 'model_price'], 'number'],
            [['is_allocable'], 'integer'],
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
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'is_allocable' => 'Is Allocable',
            'model_price' => 'Model Price',
        ];
    }

    /**
     * @inheritdoc
     * @return CabinetBoxModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CabinetboxmodelQuery(get_called_class());
    }
}

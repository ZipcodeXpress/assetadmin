<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cabinet_body".
 *
 * @property integer $body_id
 * @property string $body_name
 * @property integer $cabinet_id
 * @property integer $body_model_id
 * @property string $direction
 * @property string $sequence
 * @property integer $addr
 */
class Cabinetbody extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_body';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cabinet_id', 'body_model_id',  'sequence', 'addr'], 'required'],
            [['cabinet_id', 'body_model_id', 'addr'], 'integer'],
            [['body_name'], 'string', 'max' => 50],
            [['direction', 'sequence'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'body_id' => 'Body ID',
            'body_name' => 'Body Name',
            'cabinet_id' => 'Locker ID',
            'body_model_id' => 'Body Model',
            'direction' => 'Direction',
            'sequence' => 'Sequence',
            'addr' => 'Lock Control Address',
        ];
    }

    /**
     * @inheritdoc
     * @return CabinetbodyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CabinetbodyQuery(get_called_class());
    }
    
    public function getBodymodel()
    {
        return $this->hasOne(Cabinetbodymodel::className(),['model_id'=>'body_model_id']);
    }
    public  static function getBodyModelName()
    {
        return ArrayHelper::map(Cabinetbodymodel::find()->all(), "model_id", "model_name");
    }
}

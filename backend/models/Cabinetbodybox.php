<?php

namespace backend\models;

use Yii;
use Yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cabinet_body_box".
 *
 * @property integer $body_box_id
 * @property integer $body_model_id
 * @property integer $box_model_id
 * @property integer $row
 * @property integer $column
 * @property integer $addr
 * @property integer $create_time
 */
class Cabinetbodybox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cabinet_body_box';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body_model_id', 'box_model_id', 'row', 'column', 'addr',], 'required'],
            [['body_model_id', 'box_model_id', 'row', 'column', 'addr', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'body_box_id' => 'BodyBox ID',
            'body_model_id' => 'Body Model ID',
            'box_model_id' => 'Box Model ID',
            'row' => 'Row',
            'column' => 'Column',
            'addr' => 'Address',
            'create_time' => 'Create Time',
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
     * @return CabinetbodyboxQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CabinetbodyboxQuery(get_called_class());
    }
    
    public function getBodymodel()
    {
        return $this->hasOne(Cabinetbodymodel::className(), ['model_id' => 'body_model_id']);
    }
    public  function getBoxmodel() 
    {
        return $this->hasOne(Cabinetboxmodel::className(), ['model_id' => 'box_model_id']);
    }
    public static  function  getBDM(){
        $bodymodel = Cabinetbodymodel::find()->all();
        $bodymodel = ArrayHelper::map($bodymodel, 'model_id', 'model_name');
        return $bodymodel;
    }
    public static  function  getBXM(){
        $boxmodel = Cabinetboxmodel::find()->all();
        $boxmodel = ArrayHelper::map($boxmodel, 'model_id', 'model_name');
        return $boxmodel;
    }
}

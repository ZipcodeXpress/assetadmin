<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use Yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "o_organization_cabinet".
 *
 * @property integer $organization_id
 * @property integer $cabinet_id
 * @property integer $create_time
 */
class StoreLockerBindModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zt_oc_store_cabinet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oc_store_id', 'cabinet_id', ], 'required'],
            [['oc_store_id', 'cabinet_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oc_store_id' => 'Store ID',
            'cabinet_id' => 'Locker ID',
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
    
    
    public function getStore()
    {
        return $this->hasOne(Sellers::className(), ['seller_id'=>'oc_store_id']);
    }
    public function getCabinet() {
        return $this->hasOne(Cabinet::className(), ['cabinet_id'=>'cabinet_id']);
    }
    public static  function  getStoreName()
    {
        $stores = Sellers::find()->all();
        foreach ($stores as $key=>$store)
        {
            $stores_arr[$store['seller_id']] = $store['firstname']. ' '.$store['lastname'];
        }
        return $stores_arr;
    }
}

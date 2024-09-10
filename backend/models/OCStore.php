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
class OCStore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ztopencart_store';
    }
}

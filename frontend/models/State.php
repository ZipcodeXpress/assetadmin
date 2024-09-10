<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property string $state
 * @property string $state_code
 * @property double $tax_rate
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'state';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'state_code'], 'required'],
            [['tax_rate'], 'number'],
            [['state'], 'string', 'max' => 22],
            [['state_code'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'state' => 'State',
            'state_code' => 'State Code',
            'tax_rate' => 'Tax Rate',
        ];
    }
}

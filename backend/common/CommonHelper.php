<?php
namespace backend\common;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\State;

class CommonHelper
{
    public static function getUsStates() {
         $states = State::find()->all();
         $states = ArrayHelper::map($states, 'state_code', 'state');
         return $states;
    }
    
    public static function replace_tel($tel)
    {
        $tel = str_replace('(', '', $tel);
        $tel = str_replace(')', '', $tel);
        $tel = str_replace('-', '', $tel);
        return $tel;
    }
}

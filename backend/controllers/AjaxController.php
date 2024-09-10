<?php
namespace backend\controllers;
use backend\models\Unit;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
class AjaxController extends Controller
{
    public function actionUnit($organization_id)
    {
        $condition['organization_id'] = $organization_id;
        $_data = Unit::find()->select('unit_id,unit_name')->where($condition)->all();
        $_data = ArrayHelper::map(array_merge($_data), 'unit_id', 'unit_name');
        $_tmp = '';
        foreach ($_data as $key => $val) {
            $_tmp .= "<option value='" . $key . "'>{$val}</option>";
        }
        echo $_tmp;
    }
}
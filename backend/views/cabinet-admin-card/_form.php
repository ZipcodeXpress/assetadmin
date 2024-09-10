<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\CabinetAdminCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinet-admin-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'zp_admin_id')->dropDownList($user) ?>

    <?= $form->field($model, 'cabinet_id')->dropDownList($lockers) ?>

    <?= $form->field($model, 'rfid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 1 => 'Normal', 0 => 'Blocked',]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

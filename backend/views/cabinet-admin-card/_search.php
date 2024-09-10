<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CabinetAdminCardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinet-admin-card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cardId') ?>

    <?= $form->field($model, 'zp_admin_id') ?>

    <?= $form->field($model, 'zp_admin_name') ?>

    <?= $form->field($model, 'zp_admin_role') ?>

    <?= $form->field($model, 'cabinet_id') ?>

    <?php // echo $form->field($model, 'rfid') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

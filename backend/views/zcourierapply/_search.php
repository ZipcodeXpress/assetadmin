<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ZcourierapplySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zcourierapply-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'apply_id') ?>

    <?= $form->field($model, 'courier_id') ?>

    <?= $form->field($model, 'apply_time') ?>

    <?= $form->field($model, 'apply_photo_group_id') ?>

    <?= $form->field($model, 'process_time') ?>

    <?php // echo $form->field($model, 'process_result') ?>

    <?php // echo $form->field($model, 'process_by') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

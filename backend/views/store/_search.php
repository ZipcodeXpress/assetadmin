<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StoreSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'cabinet_id') ?>

    <?= $form->field($model, 'box_id') ?>

    <?= $form->field($model, 'from_member_id') ?>

    <?= $form->field($model, 'store_time') ?>

    <?php // echo $form->field($model, 'tracking_no') ?>

    <?php // echo $form->field($model, 'to_member_id') ?>

    <?php // echo $form->field($model, 'to_phone') ?>

    <?php // echo $form->field($model, 'pick_code') ?>

    <?php // echo $form->field($model, 'pick_expire') ?>

    <?php // echo $form->field($model, 'pick_fee') ?>

    <?php // echo $form->field($model, 'pick_time') ?>

    <?php // echo $form->field($model, 'pick_with') ?>

    <?php // echo $form->field($model, 'clean_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

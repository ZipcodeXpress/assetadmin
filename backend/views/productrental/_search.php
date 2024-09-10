<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductRentalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-rental-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rental_id') ?>

    <?= $form->field($model, 'organization_id') ?>

    <?= $form->field($model, 'cabinet_id') ?>

    <?= $form->field($model, 'product_inventory_id') ?>

    <?= $form->field($model, 'rfid') ?>

    <?php // echo $form->field($model, 'member_id') ?>

    <?php // echo $form->field($model, 'pickup_code') ?>

    <?php // echo $form->field($model, 'reserve_time') ?>

    <?php // echo $form->field($model, 'expire_time') ?>

    <?php // echo $form->field($model, 'rental_time') ?>

    <?php // echo $form->field($model, 'rental_status_code') ?>

    <?php // echo $form->field($model, 'applied_deposit') ?>

    <?php // echo $form->field($model, 'applied_daily_fee') ?>

    <?php // echo $form->field($model, 'applied_sale_amt') ?>

    <?php // echo $form->field($model, 'applied_free_days') ?>

    <?php // echo $form->field($model, 'return_locker_id') ?>

    <?php // echo $form->field($model, 'return_time') ?>

    <?php // echo $form->field($model, 'return_elapsed_days') ?>

    <?php // echo $form->field($model, 'total_charged_amt') ?>

    <?php // echo $form->field($model, 'Is_comment') ?>

    <?php // echo $form->field($model, 'Is_delete') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

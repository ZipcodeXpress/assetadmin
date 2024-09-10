<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductInventorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-inventory-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'product_inventory_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'cabinet_id') ?>

    <?= $form->field($model, 'organization_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?php // echo $form->field($model, 'col') ?>

    <?php // echo $form->field($model, 'row') ?>

    <?php // echo $form->field($model, 'rfid') ?>

    <?php // echo $form->field($model, 'product_status_code') ?>

    <?php // echo $form->field($model, 'product_service_type') ?>

    <?php // echo $form->field($model, 'reg_date') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ZdeliverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zdeliver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'deliver_id') ?>

    <?= $form->field($model, 'cargo_type_id') ?>

    <?= $form->field($model, 'cargo_worth') ?>

    <?= $form->field($model, 'cargo_weight') ?>

    <?= $form->field($model, 'box_model_id') ?>

    <?php // echo $form->field($model, 'from_member_id') ?>

    <?php // echo $form->field($model, 'from_cabinet_id') ?>

    <?php // echo $form->field($model, 'from_box_id') ?>

    <?php // echo $form->field($model, 'to_member_id') ?>

    <?php // echo $form->field($model, 'to_phone') ?>

    <?php // echo $form->field($model, 'to_name') ?>

    <?php // echo $form->field($model, 'to_cabinet_id') ?>

    <?php // echo $form->field($model, 'to_box_id') ?>

    <?php // echo $form->field($model, 'deliver_photo_group_id') ?>

    <?php // echo $form->field($model, 'dist') ?>

    <?php // echo $form->field($model, 'fee_total') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'cargo_code') ?>

    <?php // echo $form->field($model, 'pick_code') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'cargo_status') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'courier_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ComplainSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complain-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'complain_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'complain_photo_group_id') ?>

    <?= $form->field($model, 'complain_content') ?>

    <?= $form->field($model, 'process_status') ?>

    <?php // echo $form->field($model, 'process_time') ?>

    <?php // echo $form->field($model, 'process_by') ?>

    <?php // echo $form->field($model, 'process_remark') ?>

    <?php // echo $form->field($model, 'order_type') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

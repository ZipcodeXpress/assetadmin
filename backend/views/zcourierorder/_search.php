<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ZcourierorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zcourierorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'deliver_id') ?>

    <?= $form->field($model, 'courier_id') ?>

    <?= $form->field($model, 'create_time') ?>

    <?= $form->field($model, 'fetch_time') ?>

    <?php // echo $form->field($model, 'fetch_photo_group_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cancel_reason') ?>

    <?php // echo $form->field($model, 'reach_time') ?>

    <?php // echo $form->field($model, 'reach_photo_group_id') ?>

    <?php // echo $form->field($model, 'fee_total') ?>

    <?php // echo $form->field($model, 'user_rating') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

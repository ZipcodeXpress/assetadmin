<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StatementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'statement_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'statement_type') ?>

    <?= $form->field($model, 'statement_desc') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'money') ?>

    <?php // echo $form->field($model, 'frozen_money') ?>

    <?php // echo $form->field($model, 'ubi') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'order_payment_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

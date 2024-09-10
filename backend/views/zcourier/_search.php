<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ZcourierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zcourier-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'courier_id') ?>

    <?= $form->field($model, 'credit_rating') ?>

    <?= $form->field($model, 'grade') ?>

    <?= $form->field($model, 'user_rating') ?>

    <?= $form->field($model, 'total_orders') ?>

    <?php // echo $form->field($model, 'bad_orders') ?>

    <?php // echo $form->field($model, 'is_signed') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

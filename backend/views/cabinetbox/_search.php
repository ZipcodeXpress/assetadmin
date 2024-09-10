<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CabinetboxSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinetbox-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'box_id') ?>

    <?= $form->field($model, 'box_model_id') ?>

    <?= $form->field($model, 'cabinet_id') ?>

    <?= $form->field($model, 'body_id') ?>

    <?= $form->field($model, 'row') ?>

    <?php // echo $form->field($model, 'column') ?>

    <?php // echo $form->field($model, 'addr') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'blocked') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

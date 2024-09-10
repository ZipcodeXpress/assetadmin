<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CabinetbodyboxSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinetbodybox-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'body_box_id') ?>

    <?= $form->field($model, 'body_model_id') ?>

    <?= $form->field($model, 'box_model_id') ?>

    <?= $form->field($model, 'row') ?>

    <?= $form->field($model, 'column') ?>

    <?php // echo $form->field($model, 'addr') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CabinetbodySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinetbody-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'body_id') ?>

    <?= $form->field($model, 'body_name') ?>

    <?= $form->field($model, 'cabinet_id') ?>

    <?= $form->field($model, 'body_model_id') ?>

    <?= $form->field($model, 'direction') ?>

    <?php // echo $form->field($model, 'sequence') ?>

    <?php // echo $form->field($model, 'addr') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

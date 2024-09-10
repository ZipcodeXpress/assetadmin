<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourierCompanyOrganizationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courier-company-organization-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'courier_id') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'organization_id') ?>

    <?= $form->field($model, 'access_code') ?>

    <?= $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

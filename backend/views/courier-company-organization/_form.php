<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CourierCompanyOrganization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courier-company-organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id')->dropDownList($company)->label('Company') ?>

    <?= $form->field($model, 'organization_id')->dropDownList($organizations) ?>

    <?= $form->field($model, 'access_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

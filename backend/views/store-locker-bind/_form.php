<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\OrganizationCabinet;
use backend\models\StoreLockerBindModel;

/* @var $this yii\web\View */
/* @var $model backend\models\OrganizationCabinet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organization-cabinet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oc_store_id' )->dropDownList(StoreLockerBindModel::getStoreName())?>

    <?= $form->field($model, 'cabinet_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

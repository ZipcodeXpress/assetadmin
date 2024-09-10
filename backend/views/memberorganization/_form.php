<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\MemberOrganization;
use backend\common\CommonStatus;


/* @var $this yii\web\View */
/* @var $model backend\models\Memberorganization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memberorganization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_id')->textInput(['readonly'=>true]) ?>
    <?= $form->field($model->member, 'email')->textInput(['readonly'=>true]) ?>
    <?= $form->field($model->member, 'phone')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model->unit->organization, 'organization_name')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model->unit, 'unit_name')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'apply_photo_group_id')->textInput() ?>

    <?= $form->field($model, 'apply_time')->textInput() ?>

    <?= $form->field($model, 'approve_time')->textInput() ?>
    
    <?= $form->field($model, 'approve_status')->dropDownList(CommonStatus::member_organization_approve_status(), ['prompt' => '']) ?>


    <?= $form->field($model, 'charge_day')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost_offline')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(CommonStatus::member_organization_status(), ['prompt' => '']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

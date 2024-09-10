<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductInventory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container-fluid">

  <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'organization_id')->dropDownList($organizations) ?>
    <?= $form->field($model, 'product_id')->dropDownList($product) ?>


    <?= $form->field($model, 'rfid')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'member_id')->textInput() ?>-->

    <?php if (!$model->isNewRecord): ?>
    <?=    $form->field($model, 'product_status_code')->dropdownlist(CommonStatus::product_inv_status()) ?>
    <?php endif; ?>
   
    <?php if ($model->isNewRecord): ?>
    <?=    $form->field($model, 'product_status_code')->textInput([
        'readonly' => true,
        'value' =>  0   ]) ?>
      
      <?php endif; ?>
    <!--?= $form->field($model, 'product_service_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reg_date')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'end_time')->textInput() ?> -->

    <div class="form-group">


        <!--?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?-->
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
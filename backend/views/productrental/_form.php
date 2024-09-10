<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonStatus;
use backend\models\product;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductRental */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container-fluid">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'organization_id')->textInput([
        'readonly' => true ]) ?>

    <?= $form->field($model, 'cabinet_id')->textInput([ 'readonly' => true ]) ?>

  

    <?= $form->field($model, 'rfid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rental_status_code')->dropdownlist(CommonStatus::rental_status()) ?>

 <?= $form->field($model, 'email')->textInput(['readonly' => true, 'value' => $model->member->email]) ?>

   <!--     <?= $form->field($model, 'pickup_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reserve_time')->textInput(['readonly' => true ])  ?>

    <?= $form->field($model, 'expire_time')->textInput(['placeholder'=>'YYYY-MM-DD','id'=>'expire_time','value' => date("Y-m-d", $model->expire_time)])  ?>

    <?= $form->field($model, 'rental_time')->textInput(['placeholder'=>'YYYY-MM-DD','id'=>'rental_time','value' => date("Y-m-d", $model->rental_time)]) ?>

  

   <?= $form->field($model, 'applied_deposit')->textInput() ?>

    <?= $form->field($model, 'applied_daily_fee')->textInput() ?>

    <?= $form->field($model, 'applied_sale_amt')->textInput() ?>

    <?= $form->field($model, 'applied_free_days')->textInput() ?>

    <?= $form->field($model, 'return_locker_id')->textInput() ?>

    <?= $form->field($model, 'return_time')->textInput() ?>

    <?= $form->field($model, 'return_elapsed_days')->textInput() ?>

    <?= $form->field($model, 'total_charged_amt')->textInput() ?>

    <?= $form->field($model, 'Is_comment')->textInput() ?>

    <?= $form->field($model, 'Is_delete')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

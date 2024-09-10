<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cabinet_id')->textInput() ?>

    <?= $form->field($model, 'box_id')->textInput() ?>

    <?= $form->field($model, 'from_member_id')->textInput() ?>

    <?= $form->field($model, 'store_time')->textInput() ?>

    <?= $form->field($model, 'tracking_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_member_id')->textInput() ?>

    <?= $form->field($model, 'to_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pick_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pick_expire')->textInput() ?>

    <?= $form->field($model, 'pick_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pick_time')->textInput() ?>

    <?= $form->field($model, 'pick_with')->dropDownList([ 'code' => 'Code', 'app' => 'App', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'clean_time')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

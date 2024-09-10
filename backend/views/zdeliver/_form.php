<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Zdeliver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zdeliver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cargo_type_id')->textInput() ?>

    <?= $form->field($model, 'cargo_worth')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo_weight')->textInput() ?>

    <?= $form->field($model, 'box_model_id')->textInput() ?>

    <?= $form->field($model, 'from_member_id')->textInput() ?>

    <?= $form->field($model, 'from_cabinet_id')->textInput() ?>

    <?= $form->field($model, 'from_box_id')->textInput() ?>

    <?= $form->field($model, 'to_member_id')->textInput() ?>

    <?= $form->field($model, 'to_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_cabinet_id')->textInput() ?>

    <?= $form->field($model, 'to_box_id')->textInput() ?>

    <?= $form->field($model, 'deliver_photo_group_id')->textInput() ?>

    <?= $form->field($model, 'dist')->textInput() ?>

    <?= $form->field($model, 'fee_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pick_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'cargo_status')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'courier_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

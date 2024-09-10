<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zcourierorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deliver_id')->textInput() ?>

    <?= $form->field($model, 'courier_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'fetch_time')->textInput() ?>

    <?= $form->field($model, 'fetch_photo_group_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'cancel_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reach_time')->textInput() ?>

    <?= $form->field($model, 'reach_photo_group_id')->textInput() ?>

    <?= $form->field($model, 'fee_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_rating')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

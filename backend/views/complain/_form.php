<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Complain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'member_id')->textInput() ?>

    <?= $form->field($model, 'complain_photo_group_id')->textInput() ?>

    <?= $form->field($model, 'complain_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'process_status')->textInput() ?>

    <?= $form->field($model, 'process_time')->textInput() ?>

    <?= $form->field($model, 'process_by')->textInput() ?>

    <?= $form->field($model, 'process_remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_type')->dropDownList([ 'zippora_pick' => 'Zippora pick', 'ziplocker_pick' => 'Ziplocker pick', 'ziplocker_fetch' => 'Ziplocker fetch', 'ziplocker_lost' => 'Ziplocker lost', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

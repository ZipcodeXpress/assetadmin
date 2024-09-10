<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierapply */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zcourierapply-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'courier_id')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model->member, 'email')->textInput(['readonly' => true]) ?>

    <?= $form->field($model->member, 'phone')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'apply_time')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'process_result')->dropDownList(CommonStatus::proces_result_status(), ['prompt' => '']) ?>
    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Approve', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

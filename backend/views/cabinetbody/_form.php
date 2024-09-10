<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Cabinetbody;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbody */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinetbody-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'cabinet_id')->textInput() ?>

    <?= $form->field($model, 'body_name')->textInput(['maxlength' => true]) ?>

   

    <?= $form->field($model, 'body_model_id')->dropDownList(Cabinetbody::getBodyModelName(),$model->isNewRecord ?['disabled'=>false]:['disabled'=>true]) ?>


    <?= $form->field($model, 'sequence')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addr')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

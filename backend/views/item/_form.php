<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form col-sm-4">

    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->name =='SuperAdmin'):?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true,'readonly'=>true]) ?>
        <?= $form->field($model, 'type' )->dropDownList(['1' =>'Role' ,'2' =>'Permission'],['disabled'=>true])?>
    <?php else:?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'type' )->dropDownList(['1' =>'Role' ,'2' =>'Permission'])?>
    <?php endif;?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

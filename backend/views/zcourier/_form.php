<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zcourier-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model->member, 'email')->textInput(['readonly' => true]) ?>

    <?= $form->field($model->member, 'phone')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'credit_rating')->textInput() ?>

    <?= $form->field($model, 'grade')->textInput() ?>

    <?= $form->field($model, 'user_rating')->textInput() ?>

    <?= $form->field($model, 'total_orders')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'bad_orders')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'is_signed')->dropDownList([ '1'=>'Signed','0'=>'Not signed' ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

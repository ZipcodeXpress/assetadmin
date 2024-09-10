<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonHelper;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'state')->dropDownList(CommonHelper::getUsStates()) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
            'attributeLatitude' => 'latitude',
            'attributeLongitude' => 'longitude',
            'googleMapApiKey' => 'AIzaSyBP9r6J4hnxjRLqv1g2W51B7TiF03oEzr8',
        ]);?>
        
    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>
    
    <?= $form->field($model, 'address_url')->textInput() ?>

    <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'api_key')->textInput(['maxlength' => true,'value'=>'abc']) ?>

    <?= $form->field($model, 'api_secret')->textInput(['maxlength' => true,'value'=>'123']) ?>

    <?= $form->field($model, 'service_type')->dropDownList(CommonStatus::service_type(), ['prompt' => '']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
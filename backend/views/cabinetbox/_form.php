<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Cabinetboxmodel;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbox */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinetbox-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'cabinet_id')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'box_model_id')->dropDownList(ArrayHelper::map(Cabinetboxmodel::find()->all(), "model_id", "model_name"),['disabled'=>true]) ?>

    <?= $form->field($model->bodyname, 'body_name')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'row')->textInput() ?>

    <?= $form->field($model, 'column')->textInput() ?>

    <?= $form->field($model, 'addr')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([0=>'Avaliable',1=>'Not avaliable']) ?>

    <?= $form->field($model, 'blocked')->dropDownList([0=>'Not Blocked',1=>'Blocked']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

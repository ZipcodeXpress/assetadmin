<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinetbodybox */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cabinetbodybox-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'body_model_id' )->dropDownList($bodymodel)?>
    <?= $form->field($model, 'box_model_id' )->dropDownList($boxmodel)?>

    <?= $form->field($model, 'row')->textInput() ?>

    <?= $form->field($model, 'column')->textInput() ?>

    <?= $form->field($model, 'addr')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

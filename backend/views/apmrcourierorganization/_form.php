<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Courier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(isset($_GET['courierId']) && $_GET['courierId']):?>
        <?= $form->field($model, 'courier_id' )->dropDownList($courierModel)->Label('Auth Courier'); ?>
    <?php else:?>
        <?= $form->field($model, 'courier_id' )->dropDownList($courierModel)->Label('Auth Courier'); ?>
    <?php endif;?>

    <?= $form->field($model, 'organization_id' )->dropDownList($organizationModel)->Label('Have Authority of Aparment'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

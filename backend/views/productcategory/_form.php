<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'organization_id')->dropDownList($organizations) ?>
    <?= $form->field($model, 'product_cate_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_cate_desc')->textInput(['maxlength' => true]) ?>

    <!--?= $form->field($model, 'create_time')->textInput(['maxlength' => true]) ?-->

    <!--?= $form->field($model, 'update_time')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

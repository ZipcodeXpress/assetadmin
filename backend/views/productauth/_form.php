<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductAuth */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-auth-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'organization_id')->dropDownList($organizations,
     ['prompt'=>'-Choose a organization-',
     'onchange' => '
    
    $.post(
        "' . Url::toRoute('productauth/productlist') . '", 
        {id: $(this).val()}, 
        function(data){
            $("#productlist").html(data);
           }
    );
    $.post(
        "' . Url::toRoute('productauth/memberlist') . '", 
        {id: $(this).val()}, 
        function(data){
            $("#memberlist").html(data);
           }
    );'
    
  ]) ?>
    <?= $form->field($model, 'product_id')->dropDownList( [],
    [
        'prompt' => 'please select a product',
        'id' => 'productlist'
    ]
   
    ) ?>



    <?= $form->field($model, 'member_id')->dropDownList([],
    [
        'prompt' => 'please select a member to authorize the product',
        'id' => 'memberlist'
    ]
   
    ) ?>
    <?= $form->field($model, 'auth_code')->textInput([
        'readonly' => true,
        'value' =>  0   ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

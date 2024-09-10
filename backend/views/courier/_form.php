<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Courier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id' )->dropDownList($companyModel)?>

    <?= $form->field($model, 'courier_name')->textInput(['maxlength' => true]) ?>
    <?php if(strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin'):?>
    <?= $form->field($model, 'card_code')->textInput(['maxlength' => true]) ?>
    <?php endif ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([0=>'Normal',1=>'Blocked']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
<!--
$(function(){
	var phone = $('#courier-phone').val().replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
    $('#courier-phone').val(phone);
	})
$("#courier-phone").on("keyup", formatBC);

function formatBC(e){

  $(this).attr("data-oral", $(this).val().replace(/\ +/g,""));
  //$("#bankCard").attr("data-oral")获取未格式化的卡号

  var self = $.trim(e.target.value);
  var temp = this.value.replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
  if(self.length > 12){
    this.value = self.substr(0, 12);
    return this.value;
  }
  if(temp != this.value){
    this.value = temp;
  }
}  
//-->
</script>

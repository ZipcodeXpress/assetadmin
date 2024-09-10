<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Couriercompany */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="couriercompany-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
            'attributeLatitude' => 'latitude',
            'attributeLongitude' => 'longitude',
            'googleMapApiKey' => 'AIzaSyBP9r6J4hnxjRLqv1g2W51B7TiF03oEzr8',
        ]);?>
    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contract_begin')->textInput(['id'=>'contract_begin','placeholder'=>'YYYY-MM-DD','value' => date("Y-m-d", $model->contract_begin)]) ?>

    <?= $form->field($model, 'contract_end')->textInput(['id'=>'contract_end','placeholder'=>'YYYY-MM-DD','value' => date("Y-m-d", $model->contract_begin)]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script src="js/plugins/layer/laydate/laydate.js"></script>
<script>
var start = {
    elem: "#contract_begin",
    format: "YYYY/MM/DD",
    min: '2015-01-01',
    max: "2099-06-16",
    istime: false,
    istoday: true,
    choose: function(datas) {
        end.min = datas;
        end.start = datas
    }
};
var end = {
    elem: "#contract_end",
    format: "YYYY/MM/DD",
    min: '2015-01-01',
    max: "2099-06-16",
    istime: false,
    istoday: true,
    choose: function(datas) {
        start.max = datas
    }
};
laydate(start);
laydate(end);
</script>
<script type="text/javascript">
<!--
$(function(){
	var phone = $('#couriercompany-contact_phone').val().replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
    $('#couriercompany-contact_phone').val(phone);
	})
$("#couriercompany-contact_phone").on("keyup", formatBC);

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
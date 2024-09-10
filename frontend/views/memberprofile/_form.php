<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\common\CommonHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Memberprofile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memberprofile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addressline1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addressline2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->dropDownList(CommonHelper::getUsStates()) ?>

    <?= $form->field($model, 'zipcode')->textInput() ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth')->textInput() ?>

    <?= $form->field($model, 'sex')->textInput() ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::button('Save',['class'=>'btn btn-primary update_profile'])?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('.update_profile').click(function () {
        var self = $(this); 
        swal({ 
            title: "Are you sure to update the member profile?",
            text: "You will update the member profile info immediately",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Update",
            closeOnConfirm: false
        }, function () {
       	 $.ajax({
             url: "index.php?r=member/update-profile",
             type: 'post',
             data: {"id":<?=$model->member_id?>,"nick_name":$("#memberprofile-nick_name").val(),"first_name":$("#memberprofile-first_name").val(),"last_name":$("#memberprofile-last_name").val(),"addressline1":$("#memberprofile-addressline1").val(),"addressline2":$("#memberprofile-addressline2").val(),"city":$("#memberprofile-city").val(),"state":$("#memberprofile-state").val(),"zipcode":$("#memberprofile-zipcode").val(),"phone":$("#memberprofile-phone").val(),"avatar":$("#memberprofile-avatar").val(),"birth":$("#memberprofile-birth").val(),"sex":$("#memberprofile-sex").val()},
             success: function (data) {
                 // do something
                 if(data.code==200)
                 {
                	 swal("Save success！", data.msg, "success");
                	 self.parents('tr').remove();
                 }
                 else
                 {
                	 swal("Error!", data.msg, "error");
                 }
             },error:function(e){
                 alert(e.msg);
             }
         });
           
        });
    });
</script>
<script type="text/javascript">
$(function(){
	var phone = $('#memberprofile-phone').val().replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
    $('#memberprofile-phone').val(phone);
	})
$("#memberprofile-phone").on("keyup", formatP);

function formatP(e){

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
</script>


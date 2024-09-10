<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cardcode')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'status' )->dropDownList(CommonStatus::member_status())?>
    
    
    <?= $form->field($model, 'c_status' )->dropDownList(CommonStatus::member_c_status())?>

    <?= $form->field($model, 'is_email_verified')->dropDownList(['1'=>'Verified','0'=>'Not Verified' ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_profile_completed')->dropDownList(['1'=>'Completed','0'=>'Not Completed' ], ['prompt' => '']) ?>

    <?= $form->field($model, 'has_credit_card')->dropDownList([ '1'=>'Yes','0'=>'No' ], ['prompt' => '']) ?>

    <?= $form->field($model, 'cabinet_id')->textInput() ?>

    <?= $form->field($model, 'service_mode')->dropDownList([ 'zippora' => 'Zippora', 'ziplocker' => 'Ziplocker', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::button('Save',['class'=>'btn btn-primary update_member','data-id'=>$model->member_id])?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('.update_member').click(function () {
        var self = $(this); 
        swal({ 
            title: "Are you sure to update member info?",
            text: "You will update the member info immediately",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Update",
            closeOnConfirm: false
        }, function () {
       	 $.ajax({
             url: "index.php?r=member/update-member",
             type: 'post',
             data: {"id":<?=$model->member_id?>,"email":$("#member-email").val(),"cardcode":$("#member-cardcode").val(),"phone":$("#member-phone").val(),"status":$("#member-status").val(),"c_status":$("#member-c_status").val(),"is_email_verified":$("#member-is_email_verified").val(),"is_profile_completed":$("#member-is_profile_completed").val(),"has_credit_card":$("#member-has_credit_card").val(),"cabinet_id":$("#member-cabinet_id").val(),"service_mode":$("#member-service_mode").val()},
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
	var phone = $('#member-phone').val().replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
    $('#member-phone').val(phone);
	})
$("#member-phone").on("keyup", formatBC);

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
</script>

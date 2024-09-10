<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Wallet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'frozen_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubi')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::button('Save',['class'=>'btn btn-primary update_wallet'])?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $('.update_wallet').click(function () {
        var self = $(this); 
        swal({ 
            title: "Are you sure to edit?",
            text: "The data cannot be restored if you deleted！",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Update",
            closeOnConfirm: false
        }, function () {
       	 $.ajax({
             url: "index.php?r=member/update-wallet",
             type: 'post',
             data: {"id":<?=$model->member_id?>,"money":$("#wallet-money").val(),"frozen_money":$("#wallet-frozen_money").val(),"ubi":$("#wallet-ubi").val()},
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
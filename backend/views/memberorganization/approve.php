<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\MemberOrganization;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberorganization */

$this->title = 'Approve  Member Organization: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberorganizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'member_id' => $model->member_id, 'organization_id' => $model->organization_id, 'cancel_time' => $model->cancel_time]];
$this->params['breadcrumbs'][] = 'Update';
?>
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<style>
        .lightBoxGallery img {
            margin: 5px;
            width: 300px;
        }
    </style>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>

            <hr/>
           <div class="memberorganization-form">

                <?php $form = ActiveForm::begin(); ?>
            
                <?= $form->field($model, 'member_id')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->member, 'email')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->member, 'phone')->textInput(['readonly'=>true]) ?>
            
                <?= $form->field($model, 'organization_id')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->unit->organization, 'organization_name')->textInput(['readonly'=>true]) ?>
            
                <?= $form->field($model, 'unit_id')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->unit, 'unit_name')->textInput(['readonly'=>true]) ?>
            
                <?= $form->field($model, 'apply_photo_group_id')->textInput(['readonly'=>true]) ?>
                <div class="lightBoxGallery">
                  <?php if(!empty($model->photo)):?>
                      <a href="<?=Json_decode($model->photo->photos)[0]?>" title="图片" data-gallery><img src="<?=Json_decode($model->photo->photos)[0]?>"></a>
                       <div id="blueimp-gallery" class="blueimp-gallery" style="display: none;">
                            <div class="slides" style="width: 61200px;"></div>
                            <h3 class="title"></h3>
                            <a class="prev">&lt;</a>
                            <a class="next">&gt;</a>
                            <a class="close">×</a>
                            <a class="play-pause"></a>
                            <ol class="indicator"></ol>
                        </div>
                   <?php endif;?>
                </div>
            
                <?= $form->field($model, 'apply_time')->textInput(['readonly'=>true,'value' => date("Y-m-d H:i:s", $model->apply_time)]) ?>
            
                <?= $form->field($model, 'approve_time')->textInput(['readonly'=>true,'value' => date("Y-m-d H:i:s", $model->approve_time)]) ?>
                
                <?= $form->field($model, 'approve_status')->dropDownList(CommonStatus::member_organization_approve_status(), ['prompt' => '']) ?>
            
            
                <?= $form->field($model, 'charge_day')->textInput(['readonly'=>true]) ?>
            
                <?= $form->field($model, 'cost')->textInput(['maxlength' => true,'readonly'=>true]) ?>
            
                <?= $form->field($model, 'cost_offline')->textInput(['maxlength' => true]) ?>
            
                <?= $form->field($model, 'status')->dropDownList(CommonStatus::member_organization_status(), ['prompt' => '',]) ?>
            
            
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                </div>
            
                <?php ActiveForm::end(); ?>
            
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
<script src="js/content.min.js?v=1.0.0"></script>
<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script type="text/javascript">
$(function(){
	var phone = $('#member-phone').val().replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
    $('#member-phone').val(phone);
	})

</script>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\common\CommonHelper;
use backend\models\Cabinetboxmodel;

/* @var $this yii\web\View */
/* @var $model backend\models\Organization */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->dropDownList(CommonHelper::getUsStates()) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'address')->widget(\kalyabin\maplocation\SelectMapLocationWidget::className(), [
            'attributeLatitude' => 'latitude',
            'attributeLongitude' => 'longitude',
            'googleMapApiKey' => 'AIzaSyBP9r6J4hnxjRLqv1g2W51B7TiF03oEzr8',
        ]);?>

    <?= $form->field($model, 'zipcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'contract_begin')->textInput(['id'=>'contract_begin','placeholder'=>'YYYY-MM-DD','value' => date("Y-m-d", $model->contract_begin)]) ?>

    <?= $form->field($model, 'contract_end')->textInput(['placeholder'=>'YYYY-MM-DD','id'=>'contract_end','value' => date("Y-m-d", $model->contract_end)]) ?>
    
    <?= $form->field($model, 'sign_up_fee')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model, 'sign_fee_pay_online')->radioList([1=>'Yes', 0 =>'No'])->label('Sign Fee Pay online');?>
    <?= $form->field($model, 'monthly_fee')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model, 'month_fee_pay_online')->radioList([1=>'Yes', 0 =>'No'])->label('Month Fee Pay online');?>
   
    <?php if(!empty($model->box_penalty)):?>
     <label class="control-label">Box Penalty</label></br>
        <?php foreach($model->box_penalty as $model_id => $set):?>
        <label class="control-label"><?= Cabinetboxmodel::findOne(['model_id'=>$model_id])['model_name']?></label>
        <div class="form-group field-organization-monthly_fee">
        <label class="control-label">Amount</label>
        <?= Html::input("text", "Organization[box_penalty][$model_id][amount]", $set->amount)?>
        <label class="control-label">Pay Online</label>
        <?= Html::input("text", "Organization[box_penalty][$model_id][pay_online]", $set->pay_online)?>
        <label class="control-label">Grace Day</label>
        <?= Html::input("text", "Organization[box_penalty][$model_id][grace_day]", $set->grace_day)?>
         <div class="help-block"></div>
         </div>
        <?php endforeach;?>
    <?php endif;?>
    
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
    min: laydate.now(),
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
    min: laydate.now(),
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

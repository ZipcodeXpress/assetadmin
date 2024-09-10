<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\MemberOrganization;
use backend\common\CommonStatus;


/* @var $this yii\web\View */
/* @var $model backend\models\Memberorganization */

$this->title = 'Create Member Organization Bind';
$this->params['breadcrumbs'][] = ['label' => 'Memberorganizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h3><?= Html::encode($this->title) ?></h3>
            <hr/>
           <div class="memberorganization-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'member_id')->textInput()->hiddenInput(['value'=>$member->member_id])->label(false);?>
                <?= $form->field($model, 'email')->textInput(['value'=>$member->email,'readonly'=>true]) ?>
                <?= $form->field($model, 'phone')->textInput(['value'=>$member->phone,'readonly'=>true]) ?>
                <?= $form->field($model, 'organization_id')->dropDownList($organizations) ?>
                <?= $form->field($model, 'unit_id')->dropDownList(Memberorganization::getUnitNameByOrganizationId($model->organization_id))->label("Business Unit") ?>
                <?= $form->field($model, 'cost_offline')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
 <?php 
$js = '
$(function() { 
    var organization_id = $("#memberorganization-organization_id").val(); 
    init(organization_id);
});
//分类
$("#memberorganization-organization_id").change(function() {
    var organization_id = $(this).val();//获取一级目录的值
    init(organization_id);
});
    
function init(organization_id){
    $("#memberorganization-unit_id").html("<option value=\"\">'.yii::t('backend', 'Please select unit').'</option>");//二级显示目录标签
    if (organization_id > 0) {
        getUnit(organization_id);//查询二级目录的方法
    }
}
    
function getUnit(organizationId){
    var href = "'.Url::to(['/ajax/unit']).'";//请求的地址
    $.ajax({
        "type"  : "GET",
        "url"   : href,
        "data"  : {organization_id : organizationId,},//所需参数和类型
        success : function(d) {
            $("#memberorganization-unit_id").append(d);//返回值输出
        }
    });
}
';
$this->registerJs($js);
?>
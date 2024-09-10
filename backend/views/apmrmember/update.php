<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use backend\models\MemberOrganization;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberorganization */

$this->title = 'Update Memberorganization: ' . ' ' . $model->member->email;
$this->params['breadcrumbs'][] = ['label' => 'Memberorganizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'member_id' => $model->member_id, 'organization_id' => $model->organization_id, 'cancel_time' => $model->cancel_time]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h3><?= Html::encode($this->title) ?></h3>
            <hr/>
           <div class="memberorganization-form">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model->member, 'email')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->member, 'phone')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->unit->organization, 'organization_name')->textInput(['readonly'=>true]) ?>
                <?= $form->field($model->unit, 'unit_id')->dropDownList(Memberorganization::getUnitNameByOrganizationId($model->unit->organization_id))->label("Business Unit") ?>
                <?= $form->field($model, 'cost_offline')->textInput(['maxlength' => true]) ?>
                 <?php 
                        if( Yii::$app->getSession()->hasFlash('success') ) {
                            echo Alert::widget([
                                'options' => [
                                    'class' => 'alert alert-success', //这里是提示框的class
                                ],
                                'body' => Yii::$app->getSession()->getFlash('success'), //消息体
                            ]);
                        }
                        if( Yii::$app->getSession()->hasFlash('error') ) {
                            echo Alert::widget([
                                'options' => [
                                    'class' => 'alert alert-danger',
                                ],
                                'body' => Yii::$app->getSession()->getFlash('error'),
                            ]);
                        }
                    ?>
                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
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
<script type="text/javascript">
$(function(){
	var phone = $('#member-phone').val().replace(/(\d{3})(?=\d{2,}$)/g,'$1-');
    $('#member-phone').val(phone);
	})

</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

$this->title = 'Admin Update ';
?>
<div class="wrapper wrapper-content">
    <div class="ibox-content">
        <div class="row pd-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <hr>
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
            <div class="auth-item-form col-sm-4">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'id')->hiddenInput()->label('')?>

                <?= $form->field($model, 'username')->textInput(['readonly'=>true])->label('UserName') ?>
                <?php if($model->username =='admin' && $model->id!=Yii::$app->user->identity->id):?>
                    <?= $form->field($model, 'auth_key_new')->textInput(['value'=>'','readonly'=>true])->label('Password')?>
                <?php else:?>
                    <?= $form->field($model, 'auth_key_new')->textInput(['value'=>''])->label('Password')?>
                <?php endif;?>

                <?= $form->field($model, 'auth_key')->hiddenInput()->label(false)?>

                <?= $form->field($model, 'email')->textInput(['email' => true])->label('Email')?>
                <?php if(strtolower(Yii::$app->user->identity->usergroup->item_name) == 'superadmin'):?>
                <?php if($model->username =='admin'):?>
                    <?= $form->field($model->usergroup, 'item_name' )->dropDownList($item,['disabled'=>true])->label('Group')?>
                <?php else:?>
                    <?= $form->field($model->usergroup, 'item_name' )->dropDownList($item)->label('Group')?>
                <?php endif;?>

                <?php if($model->usergroup->item_name == 'Organization Manager'):?>
                    <?=$form->field($model, 'organization_ids')->checkboxList(ArrayHelper::map($organizations, "organization_id", 'organization_name'),['value'=>$organizationIDs])->label('Grant Permission to Organization(Ids)');?>
                <?php endif;?>
                <?php endif;?>
                
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>

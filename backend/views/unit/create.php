<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title = 'Create Unit';
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="css/animate.min.css" rel="stylesheet">
<link href="css/style.min862f.css?v=4.1.0" rel="stylesheet">
<div class="col-sm-12">
    <div class="ibox">
        <div class="ibox-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Create</a>
                        </li>
                        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Import</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                             <div><p><h3>Please spit the unit name by ","       e.g: "Unit1001,Unit1002,Unit1003,"</h3></p></div>
                             <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>
                            
                                <?= $form->field($model, 'organization_id' )->dropDownList($organizations)?>
                            
                                <div class="form-group">
                                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                                </div>
                            
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                            <?= $form->field($model, 'file')->fileInput() ?>
                        
                            <?= $form->field($model, 'organization_id' )->dropDownList($organizations)?>
                        
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                            </div>
                        
                            <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>

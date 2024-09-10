<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zippora Backend Management System';
$this->params['breadcrumbs'][] = $this->title;
?>
<body backgroud-color="white">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

         
           
                <span><img src="logo.png" alt="" ></span>
         
<br><br><br><br><br><br><br><br>
        </div>
      


        <div class="row">
            <div class="">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Admin Name') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Password') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Remember Me') ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="">Copyright &copy; 2016-2024 <a href="http://www.zipcodeXpress.com/" target="_blank">ZipcodeXpress</a>
        </div>
    </div>
</div>
</body>
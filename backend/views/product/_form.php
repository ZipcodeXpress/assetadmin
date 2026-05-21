<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form"></div>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'organization_id')->dropDownList($organizations) ?>
<?= $form->field($model, 'category_id')->dropDownList($productcategory) ?>

<?= $form->field($model, 'product_name')->textInput(['maxlength' => false]) ?>
<?= $form->field($model, 'boxmodel_id')->dropDownList($boxmodel) ?>
<?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'manufacturer')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'UOM')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'part_num')->textInput() ?>

<?= $form->field($model, 'model_num')->textInput() ?>

<?= $form->field($model, 'is_public')->radioList([1 => 'Yes', 0 => 'No'])->label('is public?'); ?>

<?= $form->field($model, 'product_desc')->textInput(['maxlength' => true]) ?>


<?= $form->field($model, 'imageFile')->fileInput() ?>

<?php
if ($model->product_image) {
    $thumbnail = (string) $model->product_thumbnail;
    if (preg_match('/^https?:\/\//i', $thumbnail)) {
        $imageUrl = $thumbnail;
    } else {
        $imageUrl = rtrim(Yii::$app->params['CDN_ADDRESS'], '/') . '/' . ltrim($thumbnail, '/');
    }

    echo '<img src="' . Html::encode($imageUrl) . '" width="90px">&nbsp;&nbsp;&nbsp;';
    echo Html::a('Delete', ['deletefile', 'id' => $model->product_id], ['class' => 'btn btn-danger']) . '<p>';
}

?>

<!--?= $form->field($model, 'product_thumbnail')->textInput(['maxlength' => true]) ?-->

<?= $form->field($model, 'instruction')->textArea(['maxlength' => true])->label('Instruction'); ?>



<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
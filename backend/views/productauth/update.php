<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductAuth */

$this->title = 'Update Product Auth: ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Auths', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id, 'member_id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-auth-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

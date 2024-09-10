<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductRental */

$this->title = 'Update Product Rental: ' . $model->rental_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Rentals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rental_id, 'url' => ['view', 'id' => $model->rental_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>

            <hr />



            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
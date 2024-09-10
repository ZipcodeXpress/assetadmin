<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Update Product: ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = 'Update';
?>


    <div class="wrapper wrapper-content">
        <div class="user-create">
            <div class="ibox-content">
                <h1><?= Html::encode($this->title) ?></h1>

                <hr/>
                <?= $this->render('_form', [
                    'model' => $model,
                    'productcategory' => $productcategory,
                    'organizations' => $organizations,
                    'boxmodel' =>$boxmodel,
                ]) ?>
            </div>
        </div>
    </div>
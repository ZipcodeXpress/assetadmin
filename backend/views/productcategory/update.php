<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */

$this->title = Yii::t('app', 'Update Product Category: {nameAttribute}', [
    'nameAttribute' => $model->product_cate_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_cate_id, 'url' => ['view', 'id' => $model->product_cate_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
                'organizations'=>$organizations,
            ]) ?>
        </div>
    </div>
</div>

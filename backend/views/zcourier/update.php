<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourier */

$this->title = 'Update Zcourier: ' . ' ' . $model->courier_id;
$this->params['breadcrumbs'][] = ['label' => 'Zcouriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->courier_id, 'url' => ['view', 'id' => $model->courier_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
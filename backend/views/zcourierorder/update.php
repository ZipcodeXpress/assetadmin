<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierorder */

$this->title = 'Update Zcourierorder: ' . ' ' . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Zcourierorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zcourierorder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

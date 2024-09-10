<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinet */

$this->title = $model->cabinet_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cabinet_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cabinet_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cabinet_id',
            'state',
            'city',
            'address',
            'zipcode',
            'latitude',
            'longitude',
            'api_key',
            'api_secret',
            'service_type',
            'create_time:datetime',
        ],
    ]) ?>

</div>

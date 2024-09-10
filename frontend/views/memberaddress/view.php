<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaddress */

$this->title = $model->address_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberaddresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaddress-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->address_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->address_id], [
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
            'address_id',
            'member_id',
            'first_name',
            'last_name',
            'state',
            'city',
            'address',
            'longitude',
            'latitude',
            'zipcode',
            'create_time:datetime',
        ],
    ]) ?>

</div>

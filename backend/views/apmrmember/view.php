<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberorganization */

$this->title = $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberorganizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberorganization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'member_id' => $model->member_id, 'organization_id' => $model->organization_id, 'cancel_time' => $model->cancel_time], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'member_id' => $model->member_id, 'organization_id' => $model->organization_id, 'cancel_time' => $model->cancel_time], [
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
            'member_id',
            'organization_id',
            'building_id',
            'room_id',
            'apply_photo_group_id',
            'apply_time:datetime',
            'approve_time:datetime',
            'approve_status',
            'charge_day',
            'price',
            'cost',
            'cost_offline',
            'status',
            'cancel_time:datetime',
            'create_time:datetime',
        ],
    ]) ?>

</div>

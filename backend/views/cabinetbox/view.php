<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbox */

$this->title = $model->box_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinetboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinetbox-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->box_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->box_id], [
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
            'box_id',
            'box_model_id',
            'cabinet_id',
            'body_id',
            'row',
            'column',
            'addr',
            'status',
            'blocked',
            'update_time:datetime',
            'create_time:datetime',
        ],
    ]) ?>

</div>

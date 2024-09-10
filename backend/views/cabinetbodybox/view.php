<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinetbodybox */

$this->title = $model->body_box_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinetbodyboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinetbodybox-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->body_box_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->body_box_id], [
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
            'body_box_id',
            'body_model_id',
            'box_model_id',
            'row',
            'column',
            'addr',
            'create_time:datetime',
        ],
    ]) ?>

</div>

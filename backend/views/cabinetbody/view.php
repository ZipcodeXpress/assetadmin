<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbody */

$this->title = $model->body_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinetbodies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinetbody-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->body_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->body_id], [
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
            'body_id',
            'body_name',
            'cabinet_id',
            'body_model_id',
            'direction',
            'sequence',
            'addr',
        ],
    ]) ?>

</div>

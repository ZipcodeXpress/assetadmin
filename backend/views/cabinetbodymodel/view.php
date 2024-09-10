<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinetbodymodel */

$this->title = $model->model_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinetbodymodels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinetbodymodel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->model_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->model_id], [
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
            'model_id',
            'model_name',
        ],
    ]) ?>

</div>

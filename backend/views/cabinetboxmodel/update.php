<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CabinetBoxModel */

$this->title = 'Update Box Model: ' . ' ' . $model->model_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Box Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model_id, 'url' => ['view', 'id' => $model->model_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>
            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

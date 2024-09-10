<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinet */

$this->title = 'Update Locker: ' . ' ' . $model->cabinet_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cabinet_id, 'url' => ['view', 'id' => $model->cabinet_id]];
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

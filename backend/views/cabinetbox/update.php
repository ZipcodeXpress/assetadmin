<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbox */

$this->title = 'Update Locker Box: ' . ' ' . $model->box_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Boxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->box_id, 'url' => ['view', 'id' => $model->box_id]];
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
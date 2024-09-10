<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinetbodybox */

$this->title = 'Update Locker Body Box Relationship: ' . ' ' . $model->body_box_id;
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Body Boxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->body_box_id, 'url' => ['view', 'id' => $model->body_box_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
                'bodymodel' => $bodymodel,
                'boxmodel'=>$boxmodel,
            ]) ?>
        </div>
    </div>
</div>


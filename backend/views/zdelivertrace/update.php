<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Zdelivertrace */

$this->title = 'Update Zdelivertrace: ' . ' ' . $model->trace_id;
$this->params['breadcrumbs'][] = ['label' => 'Zdelivertraces', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->trace_id, 'url' => ['view', 'id' => $model->trace_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zdelivertrace-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

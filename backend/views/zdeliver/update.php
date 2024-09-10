<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Zdeliver */

$this->title = 'Update Zdeliver: ' . ' ' . $model->deliver_id;
$this->params['breadcrumbs'][] = ['label' => 'Zdelivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->deliver_id, 'url' => ['view', 'id' => $model->deliver_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="zdeliver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

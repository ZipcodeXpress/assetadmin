<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Complain */

$this->title = 'Update Complain: ' . ' ' . $model->complain_id;
$this->params['breadcrumbs'][] = ['label' => 'Complains', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->complain_id, 'url' => ['view', 'id' => $model->complain_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complain-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Statement */

$this->title = 'Update Statement: ' . ' ' . $model->statement_id;
$this->params['breadcrumbs'][] = ['label' => 'Statements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->statement_id, 'url' => ['view', 'id' => $model->statement_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="statement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

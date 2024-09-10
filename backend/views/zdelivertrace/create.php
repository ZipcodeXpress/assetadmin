<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Zdelivertrace */

$this->title = 'Create Zdelivertrace';
$this->params['breadcrumbs'][] = ['label' => 'Zdelivertraces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zdelivertrace-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

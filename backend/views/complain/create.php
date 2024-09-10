<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Complain */

$this->title = 'Create Complain';
$this->params['breadcrumbs'][] = ['label' => 'Complains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

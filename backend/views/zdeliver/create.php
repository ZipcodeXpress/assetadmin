<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Zdeliver */

$this->title = 'Create Zdeliver';
$this->params['breadcrumbs'][] = ['label' => 'Zdelivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zdeliver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

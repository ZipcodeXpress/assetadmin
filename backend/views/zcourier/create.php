<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Zcourier */

$this->title = 'Create Zcourier';
$this->params['breadcrumbs'][] = ['label' => 'Zcouriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zcourier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

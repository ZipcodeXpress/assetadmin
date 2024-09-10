<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbox */

$this->title = 'Create Locker Box';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Boxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
           <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
    </div>
</div>
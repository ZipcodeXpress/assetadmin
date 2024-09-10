<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cabinetbodymodel */

$this->title = 'Create Body Model';
$this->params['breadcrumbs'][] = ['label' => 'Cabinetbodymodels', 'url' => ['index']];
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

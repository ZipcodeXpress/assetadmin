<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cabinetbody */

$this->title = 'Create Locker Body';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Bodies', 'url' => ['index']];
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

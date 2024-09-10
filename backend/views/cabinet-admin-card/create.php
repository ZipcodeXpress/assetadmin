<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CabinetAdminCard */

$this->title = 'Create Locker Admin Card';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Admin Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="cabinet-admin-card-create">
        <div class="ibox-content">
           <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user'=>$user,
        'lockers'=>$lockers,
    ]) ?>
        </div>
    </div>
</div>

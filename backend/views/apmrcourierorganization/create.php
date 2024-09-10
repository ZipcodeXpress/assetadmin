<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Courier */

$this->title = 'Authorize Courier';
$this->params['breadcrumbs'][] = ['label' => 'Couriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
           <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'courierModel'=>$courierModel,
        'organizationModel'=>$organizationModel,
    ]) ?>
        </div>
    </div>
</div>

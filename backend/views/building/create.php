<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Building */

$this->title = 'Create Building';
$this->params['breadcrumbs'][] = ['label' => 'Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
           <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'organizationModel'=>$organizationModel,
    ]) ?>
        </div>
    </div>
</div>


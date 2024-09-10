<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Building */

$this->title = 'Update Building: ' . ' ' . $model->building_id;
$this->params['breadcrumbs'][] = ['label' => 'Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->building_id, 'url' => ['view', 'id' => $model->building_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
                'organizationModel'=>$organizationModel,
            ]) ?>
        </div>
    </div>
</div>
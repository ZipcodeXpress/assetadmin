<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrganizationCabinet */

$this->title = 'Update Store Locker Bind: ' . ' ' . $model->oc_store_id;
$this->params['breadcrumbs'][] = ['label' => 'Stores Lockers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->oc_store_id, 'url' => ['view', 'oc_store_id' => $model->oc_store_id, 'cabinet_id' => $model->cabinet_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

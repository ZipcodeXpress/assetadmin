<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrganizationCabinet */

$this->title = 'Update Organization Locker: ' . ' ' . $model->organization_id;
$this->params['breadcrumbs'][] = ['label' => 'Organization Lockers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->organization_id, 'url' => ['view', 'organization_id' => $model->organization_id, 'cabinet_id' => $model->cabinet_id]];
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

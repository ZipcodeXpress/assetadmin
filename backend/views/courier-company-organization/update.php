<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CourierCompanyOrganization */

$this->title = 'Update Corp Courier: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Courier Company Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->courier_id, 'url' => ['view', 'id' => $model->courier_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="courier-company-organization-update">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
                'company'=>$company,
                'organizations'=>$organizations,
            ]) ?>
        </div>
    </div>
</div>
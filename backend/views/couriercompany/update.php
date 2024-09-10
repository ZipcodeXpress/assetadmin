<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Couriercompany */

$this->title = 'Update Company Info: ' . ' ' . $model->company_id;
$this->params['breadcrumbs'][] = ['label' => 'Couriercompanies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_id, 'url' => ['view', 'id' => $model->company_id]];
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

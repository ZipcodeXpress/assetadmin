<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CourierCompanyOrganization */

$this->title = 'Create Corp Courier';
$this->params['breadcrumbs'][] = ['label' => 'Courier Company Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="courier-company-organization-create">
        <div class="ibox-content">
           <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'company'=>$company,
        'organizations'=>$organizations,
    ]) ?>
        </div>
    </div>
</div>

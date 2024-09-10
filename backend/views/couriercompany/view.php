<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Couriercompany */

$this->title = $model->company_id;
$this->params['breadcrumbs'][] = ['label' => 'Couriercompanies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="couriercompany-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->company_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->company_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'company_id',
            'company_name',
            'logo',
            'address',
            'contact_name',
            'contact_phone',
            'contract_begin',
            'contract_end',
            'create_time:datetime',
        ],
    ]) ?>

</div>

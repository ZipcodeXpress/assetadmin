<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Courier */

$this->title = 'Update Courier: ' . ' ' . $model->courier_id;
$this->params['breadcrumbs'][] = ['label' => 'Couriers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->courier_id, 'url' => ['view', 'id' => $model->courier_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
                'companyModel'=>$companyModel,
            ]) ?>
        </div>
    </div>
</div>

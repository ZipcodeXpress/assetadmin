<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CabinetAdminCard */

$this->title = 'Update Locker Admin Card: '.$model->zp_admin_name;
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Admin Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->card_id, 'url' => ['view', 'id' => $model->card_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="cabinet-admin-card-create">
        <div class="ibox-content">
            <h4><?= Html::encode($this->title) ?></h4>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
                'user'=>$user,
                'lockers'=>$lockers,
            ]) ?>
        </div>
    </div>
</div>
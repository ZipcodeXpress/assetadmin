<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Memberprofile */

$this->title = 'Update Memberprofile: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberprofiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

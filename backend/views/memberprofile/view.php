<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberprofile */

$this->title = $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Memberprofiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberprofile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->member_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->member_id], [
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
            'member_id',
            'nick_name',
            'first_name',
            'last_name',
            'addressline1',
            'addressline2',
            'city',
            'state',
            'zipcode',
            'phone',
            'birth',
            'sex',
            'avatar',
            'profile_id',
            'create_time:datetime',
        ],
    ]) ?>

</div>

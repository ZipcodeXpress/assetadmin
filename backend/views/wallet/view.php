<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Wallet */

$this->title = "Member ".$model->member_id." Wallet Details";
$this->params['breadcrumbs'][] = ['label' => 'Wallets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                    <h2><?= Html::encode($this->title) ?></h2>
                    </div>
                    </div>
                

                    <div class="table-responsive">
                   <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'member_id',
                            ['label'=>'From Memeber Email','value'=>$model->member->email,],
                            ['label'=>'From Member Phone','value'=>$model->member->phone,],
                            'money',
                            'frozen_money',
                            'ubi',
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>
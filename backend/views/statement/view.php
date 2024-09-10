<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Statement */

$this->title = "Statements Of Account Details:".$model->statement_id;
$this->params['breadcrumbs'][] = ['label' => 'Statements', 'url' => ['index']];
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
                                'statement_id',
                                'member_id',
                                ['label'=>'Memeber Email','value'=>$model->member->email,],
                                ['label'=>'Member Phone','value'=>$model->member->phone,],
                                'statement_type',
                                'statement_desc',
                                'amount',
                                'money',
                                'frozen_money',
                                'ubi',
                                'channel',
                                'extra',
                                'order_id',
                                //'order_payment_id',
                                [
                                'label'=>'create time',
                                'value' =>  Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
                                ],
                                //'create_time:datetime',
                            ],
                        ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

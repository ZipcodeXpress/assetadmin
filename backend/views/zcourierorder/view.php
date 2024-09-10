<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierorder */

$this->title = "Orders ".$model->order_id." Details:";
$this->params['breadcrumbs'][] = ['label' => 'Zcourierorders', 'url' => ['index']];
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
                            'order_id',
                            'deliver_id',
                            'courier_id',
                            ['label'=>'Email',  'value' => $model->member->email],
                            ['label'=>'Phone',  'value' => $model->member->phone],
                            [
                                'label'=>'create time',
                                'value' =>  Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
                            ],
                            [
                                'label'=>'fetch time',
                                'value' =>  Yii::$app->formatter->asDate($model->fetch_time,"php:Y-m-d H:i:s"),
                            ],
                            //'create_time:datetime',
                            //'fetch_time:datetime',
                            'fetch_photo_group_id',
                            [
                                'label'=>'Status',
                                'value'=>CommonStatus::deliver_status()[$model->status],
                            ],
                            //'status',
                            'cancel_reason',
//                             [
//                                 'label'=>'reach time',
//                                 'value' =>  Yii::$app->formatter->asDate($model->reach_time,"php:Y-m-d H:i:s"),
//                             ],
                            //'reach_time:datetime',
                            'fee_total',
                            'user_rating',
                            'remark',
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>


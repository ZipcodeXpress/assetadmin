<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ZcourierorderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ZXP Courier Orders List';
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
                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                    
                                //'order_id',
                                'deliver_id',
                                //'courier_id',
                                ['label'=>'Courier Email',  'attribute' => 'email',  'value' => 'member.email' ],
                                ['label'=>'Courier Phone',  'attribute' => 'phone',  'value' => 'member.phone' ],
                                [
                                    'attribute' => 'create_time',
                                    'format' => 'text',
                                    'value' => function($data){return date("Y-m-d H:i:s",($data->create_time));},
                                ],
                                [
                                    'attribute' => 'fetch_time',
                                    'format' => 'text',
                                    'value' => function($data){return date("Y-m-d H:i:s",($data->fetch_time));},
                                ],
                                //'create_time:datetime',
                                //'fetch_time:datetime',
                                //'fetch_photo_group_id',
                                [
                                    'attribute' => 'status',
                                    'value'=>function ($model,$key,$index,$column){
                                         return CommonStatus::deliver_status()[$model->status];
                                     },
                                    'filter' => CommonStatus::deliver_status(),
                                ],
                                //'status',
                                'cancel_reason',
                                //'reach_time:datetime',
                                //'reach_photo_group_id',
                                'fee_total',
                                'user_rating',
                                'remark',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template' => '{View}',
                                    'buttons' => [
                                        'View' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-view"></i> Details',
                                            Url::toRoute(['zcourierorder/view','id'=>$key]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                            );
                                        },
                                        ],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

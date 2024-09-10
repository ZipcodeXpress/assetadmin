<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ZcourierapplySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ZXP courier application';
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
                
                            //'apply_id',
                            //'courier_id',
                            ['label'=>'Email',  'attribute' => 'email',  'value' => 'member.email' ],
                            ['label'=>'Phone',  'attribute' => 'phone',  'value' => 'member.phone' ],
                            //'apply_time:datetime',
                            [
                                'attribute' => 'apply_time',
                                'format' => 'text',
                                'value' => function($data){return date("Y-m-d H:i:s",($data->apply_time));},
                            ],
                            //'apply_photo_group_id',
                            [
                                'attribute' => 'process_time',
                                'format' => 'text',
                                'value' => function($data){return date("Y-m-d H:i:s",($data->process_time));},
                            ],
                            //'process_time:datetime',
                            //'process_result',
                            [
                                    'attribute' => 'process_result',
                                    'value'=>function ($model,$key,$index,$column){
                                       return CommonStatus::proces_result_status()[$model->process_result];
                                    },
                                    'filter' => CommonStatus::proces_result_status(),
                                ],
                            //'process_by',
                            ['label'=>'Process_by',  'attribute' => 'username',  'value' => 'processMember.username' ],
                            'remark',
                
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{update} {View}',
                                'buttons' => [
                                    'update' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-edit"></i> Approve',
                                        Url::toRoute(['zcourierapply/update','id'=>$key]),
                                        [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]
                                        );
                                    },
                                    'View' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['zcourierapply/view','id'=>$key]),
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
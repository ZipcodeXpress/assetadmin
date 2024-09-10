<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ZdelivertraceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ZXP Deliver Traces';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="table-responsive">
                     <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                
                            //'trace_id',
                            'deliver_id',
                            //'create_time:datetime',
                            'trace',
                            'desc',
                            [
                            'attribute' => 'create_time',
                            'format' => 'text',
                            'value' => function($data){return date("Y-m-d H:i:s",($data->create_time));},
                            ],
                
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{View}',
                                'buttons' => [
                                    'View' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['zdelivertrace/view','id'=>$key]),
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
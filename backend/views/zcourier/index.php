<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ZcourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zcouriers';
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
                
                            //'courier_id',
                            ['label'=>'Email',  'attribute' => 'email',  'value' => 'member.email' ],
                            ['label'=>'Phone',  'attribute' => 'phone',  'value' => 'member.phone' ],
                            'credit_rating',
                            'grade',
                            'user_rating',
                            'total_orders',
                            'bad_orders',
                            //'is_signed',
                            [
                                'attribute' => 'is_signed',
                                'value' => function ($model,$key,$index,$column)
                                         {
                                            return $model->is_signed==1 ?'Signed':'Not signed';
                                         },
                                'filter' => ['1'=>'Signed','0'=>'Not signed'],
                            ],
                
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{update} {View}',
                                'buttons' => [
                                    'update' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-edit"></i> Edit',
                                        Url::toRoute(['zcourier/update','id'=>$key]),
                                        [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]
                                        );
                                    },
                                    'View' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['zcourier/view','id'=>$key]),
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

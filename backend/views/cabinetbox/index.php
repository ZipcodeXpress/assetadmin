<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use backend\models\Cabinetbox;
use backend\models\Cabinetboxmodel;
use backend\models\Cabinetbody;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CabinetboxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locker Box';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                   <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width'=>'50','height' => '40'],],
                        
                                    //'box_id',
                                    [
                                        'label'=>'Locker ID',
                                        'attribute' => 'cabinet_id',
                                        'headerOptions' => ['width' => '120'],
                                    ],
                                    //'body_id',
                                    [
                                    'label'=>'Body Name',
                                    'headerOptions' => ['width' => '130'],
                                    'attribute' => 'body_name',
                                    'value' => function ($model) { return $model->bodyname->body_name; },
                                    'filter'=> ArrayHelper::map(Cabinetbody::find()->all(), "body_id", "body_name"),
                                    ],
                                    //'box_model_id',
                                    [
                                    'label'=>'Box Model Name',
                                    'attribute' => 'model_name',
                                    'headerOptions' => ['width' => '130'],
                                    'value' => function ($model) { return $model->boxmodel->model_name; },
                                    'filter'=> ArrayHelper::map(Cabinetboxmodel::find()->all(), "model_id", "model_name"),
                                    ],
                                    [
                                        'label'=>'Row',
                                        'attribute' => 'row',
                                        'headerOptions' => ['width' => '80'],
                                    ],
                                    [
                                        'label'=>'Column',
                                        'attribute' => 'column',
                                        'headerOptions' => ['width' => '80'],
                                    ],
                                    [
                                        'label'=>'Lock Address',
                                        'attribute' => 'addr',
                                        'headerOptions' => ['width' => '120'],
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'headerOptions' => ['width' => '120'],
                                        'value'=>function ($model,$key,$index,$column){
                                            switch ($model->status)
                                            {
                                                case 0:
                                                    return "Avaliable";
                                                case 1:
                                                    return "Not avaliable";
                                                default:
                                                    return "Unknow status";
                                            }
                                        },
                                        'filter' => [  
                                            0 => 'Avaliable',
                                            1 => 'Not Avaliable',
                                         ],
                                    ],
                                    //'status',
                                    [
                                        'attribute' => 'blocked',
                                        'headerOptions' => ['width' => '120'],
                                        'value'=>function ($model,$key,$index,$column){
                                            switch ($model->blocked)
                                            {
                                                case 0:
                                                    return "Not Blocked";
                                                case 1:
                                                    return "Blocked";
                                                default:
                                                    return "Unknow status";
                                            }
                                        },
                                        'filter' => [   0 => 'Not Blocked',
                                            1 => 'Blocked',
                                        ],
                                    ],
                                    //'blocked',
                                    // 'update_time:datetime',
                                    // 'create_time:datetime',
                        
                                    ['class' => 'yii\grid\ActionColumn',
                                        'header' => 'Action',
                                        'headerOptions' => ['width' => '120'],
                                        'template' => ' {update} ',//只需要展示删除和更新{view}{delete}
                                        'buttons' => [
                                            'update' => function($url, $model, $key){
                                            return Html::a('<i class="fa fa-edit"></i> Edit',
                                                Url::toRoute(['cabinetbox/update','id'=>$key]),
                                                [
                                                    'class' => 'btn btn-primary btn-xs',
                                                ]
                                                );
                                            },
//                                             'delete' => function($url, $model, $key){
//                                             return Html::a('<i class="fa fa-del"></i> Delete',
//                                                 Url::toRoute(['cabinetbox/delete','id'=>$key]),
//                                                 [
//                                                     'class' => 'btn btn-default btn-xs',
//                                                     'data' => ['confirm' => 'Are you sure to delete？',]
//                                                 ]
//                                                 );
//                                             },
                                            ],
                                    ],
                                ],
                            ]); ?>
                </div>
            </div>
        </div>

    </div>
</div>
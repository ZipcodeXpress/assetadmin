<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\models\Cabinetbody;
use yii\bootstrap\Alert;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CabinetAdminCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locker Admin Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                    <p>
                    <?php if(true):?>
                        <?= Html::a('Create Locker Admin Card', ['create'], ['class' => 'btn btn-success']) ?>
                    <?php endif ?>
                    </p>
                    </div>
                    </div>
                    <?php 
                    if( Yii::$app->getSession()->hasFlash('success') ) {
                        echo Alert::widget([
                            'options' => [
                                'class' => 'alert alert-success', //这里是提示框的class
                            ],
                            'body' => Yii::$app->getSession()->getFlash('success'), //消息体
                        ]);
                    }
                    if( Yii::$app->getSession()->hasFlash('error') ) {
                        echo Alert::widget([
                            'options' => [
                                'class' => 'alert alert-danger',
                            ],
                            'body' => Yii::$app->getSession()->getFlash('error'),
                        ]);
                    }
                    ?>
                    <div class="table-responsive">
                       <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'options' => ['class' => 'table table-striped table-bordered detail-view'],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '50','height'=>'40'],],
                                ['attribute'=>'cabinet_id', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'zp_admin_name', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'zp_admin_role', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'rfid', 'headerOptions' => ['width' => '120']],
                                [
                                    'attribute'=>'status', 
                                    'headerOptions' => ['width' => '120'],
                                    'value'=>function ($model,$key,$index,$column){
                                          return  CommonStatus::card_status()[$model->status];   
                                    },
                                    'filter' => CommonStatus::card_status()
                                ],
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '130'],
                                    'header' => 'Action',
                                    'template' => '{update} {delete}',//只需要展示删除和更新{view}
                                    'buttons' => [
                                           'update' => function($url, $model, $key){
                                                 return Html::a('<i class="fa fa-edit"></i> Edit', Url::toRoute(['cabinet-admin-card/update','id'=>$key]),['class' => 'btn btn-primary btn-xs',] );
                                            },
                                            'delete' => function($url, $model, $key){
                                            return Html::a('<i class="fa fa-del"></i> Delete',
                                                Url::toRoute(['cabinet-admin-card/delete','id'=>$key]),
                                                [
                                                    'class' => 'btn btn-default btn-xs',
                                                    'data' => ['confirm' => 'Are you sure to delete？',]
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

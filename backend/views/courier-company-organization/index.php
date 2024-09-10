<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourierCompanyOrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Corp Couriers Manage';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                    <h3><?= Html::encode($this->title) ?></h3>
                    <p>
                    <?php if(true):?>
                        <?= Html::a('Create Corp Courier', ['create'], ['class' => 'btn btn-primary']) ?>
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
                                ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '40','height'=>'40'],],
                                [
                                    'attribute'=>'company_name', 
                                    'headerOptions' => ['width' => '120'],
                                    'value'=> function ($model,$key,$index,$column){
                                       if(empty($model->company))return null;
                                       return  $model->company->company_name;
                                    },
                                ],
                                [
                                    'attribute'=>'organization_name',
                                    'headerOptions' => ['width' => '120'],
                                    'value'=> function ($model,$key,$index,$column){
                                    if(empty($model->organization))return null;
                                    return  $model->organization->organization_name;
                                    },
                                ],
                                ['attribute'=>'access_code', 'headerOptions' => ['width' => '120']],
                                [
                                    'attribute'=>'create_time', 
                                    'headerOptions' => ['width' => '120'],
                                    'value'=>function ($model,$key,$index,$column){
                                         return empty($model->create_time)?null:date("Y-m-d H:i:s",($model->create_time));
                                    },
                                ],
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '130'],
                                    'header' => 'Action',
                                    'template' => '{update} {authorize} {delete}',//只需要展示删除和更新{view}
                                    'buttons' => [
                                           'update' => function($url, $model, $key){
                                                 return Html::a('<i class="fa fa-edit"></i> Edit', Url::toRoute(['courier-company-organization/update','id'=>$key]),['class' => 'btn btn-primary btn-xs',] );
                                            },
                                            'authorize' => function($url, $model, $key){
                                            return Html::a('<i class="fa fa-unlock-alt"></i> Authorize',
                                                Url::toRoute(['apmrcourierorganization/create','courierId'=>$model->courier_id]),
                                                [
                                                    'class' => 'btn btn-danger btn-xs',
                                                ]
                                                );
                                            },
                                            'delete' => function($url, $model, $key){
                                            return Html::a('<i class="fa fa-del"></i> Delete',
                                                Url::toRoute(['courier-company-organization/delete','id'=>$key]),
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

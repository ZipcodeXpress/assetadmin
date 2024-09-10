<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
use backend\models\MemberOrganization;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberorganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Member Organization Bind';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
             
                <div class="ibox-content">
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
                   <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '50','height'=>'40'],],
                            ['label'=>'Member ID',  'attribute' => 'member_id',  'value' => 'member_id' ,'headerOptions' => ['width' => '95'] ],
                            ['label'=>'Member Email',  'attribute' => 'email',  'value' => 'member.email' ,'headerOptions' => ['width' => '120'],],
                            [
                                'label'=>'Member Phone',  
                                'attribute' => 'phone', 
                                'headerOptions' => ['width' => '80'],
                                'value' => function ($model)
                                {
                                    if(empty($model->member->phone))return null;
                                    return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $model->member->phone);
                                },
                            ],
                            //['label'=>'Organization ID',  'attribute' => 'organization_id',  'value' => 'organization_id' ,'headerOptions' => ['width' => '100'] ],
                            [
                                'label'=>'Organization',  
                                'attribute' => 'organization_name',  
                                'headerOptions' => ['width' => '120'],
                                'value' => function ($model) { return $model->organization->organization_name;
                                },
                                'filter' => Memberorganization::getOrganizationName(),
                            ],
                            //['label'=>'Unit ID',  'attribute' => 'unit_id',  'value' => 'unit_id' ,'headerOptions' => ['width' => '100'] ],
                         /*   [
                                'label'=>'Business Unit',  
                                'attribute' => 'unit_name',  
                                'headerOptions' => ['width' => '100'],
                                'value' => function ($model) { return $model->unit->unit_name; },
                                //'filter' => Memberorganization::getUnitName(),
                            ],*/
                            //'apply_photo_group_id',
                            // 'apply_time:datetime',
                            [
                                'attribute' => 'approve_time',
                                'headerOptions' => ['width' => '120'],
                                'format' => 'text',
                                'value' => function($data){return empty($data->approve_time)?null:date("Y-m-d",($data->approve_time));},
                            ],
                            // 'approve_time:datetime',
                            [
                                'attribute' => 'approve_status',
                                'headerOptions' => ['width' => '120'],
                                'value'=>function ($model,$key,$index,$column){
                                    return  CommonStatus::member_organization_approve_status()[$model->approve_status];
                                },
                                'filter' => CommonStatus::member_organization_approve_status(),
                            ],
                             //'approve_status',
                             //['attribute' => 'charge_day','headerOptions' => ['width' => '100'],],
                             //['attribute' => 'cost','headerOptions' => ['width' => '100'],],
                             //['attribute' => 'cost_offline','headerOptions' => ['width' => '100'],],
                             //'charge_day',
                             //'price',
                             //'cost',
                             //'cost_offline',
                             //'status',
                             [
                                 'attribute' => 'status',
                                 'headerOptions' => ['width' => '120'],
                                 'value'=>function ($model,$key,$index,$column){
                                 return  CommonStatus::member_organization_status()[$model->status];
                                 },
                                 'filter' => CommonStatus::member_organization_status(),
                             ],
//                              [
//                                 'attribute' => 'cancel_time',
//                                 'format' => 'text',
//                                 'value' => function($data){return date("Y-m-d H:i:s",($data->cancel_time));},
//                             ],
                            // 'create_time:datetime',
                
                            ['class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '120'],
                                'header' => 'Action',
                               // 'template' => '{approve} {update}',//只需要展示删除和更新{view}
                               'template' => '{approve}',
                                'buttons' => [
                                        'approve' => function($url, $model, $key){
                                            if($model->approve_status==1)
                                            {
                                                if($model->status==3)
                                                {
                                                    return Html::a('<i class="fa fa-edit"></i>  Recovery',
                                                        Url::toRoute(['memberorganization/approve','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
                                                        [
                                                            'class' => 'btn btn-danger btn-xs',
                                                            'data' => ['confirm' => 'Are you sure to recover this user？',]
                                                        ]
                                                        );
                                                }
                                                else 
                                                {
                                                    return Html::a('<i class="fa fa-edit"></i>  Cancel',
                                                        Url::toRoute(['memberorganization/approve','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
                                                        [
                                                            'class' => 'btn btn-danger btn-xs',
                                                            'data' => ['confirm' => 'Are you sure to cancel this user？',]
                                                        ]
                                                        );
                                                }
                                            }
                                            else 
                                            {
                                                return Html::a('<i class="fa fa-edit"></i> Approve',
                                                    Url::toRoute(['memberorganization/approve','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
                                                    [
                                                       'class' => 'btn btn-primary btn-xs',
                                                        'data' => ['confirm' => 'Are you sure to approve this user？',]
                                                    ]
                                                    );
                                            }
                                        },
                                        'update' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-edit"></i> Update',
                                            Url::toRoute(['memberorganization/update','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
                                            [
                                                'class' => 'btn btn-warning btn-xs',
                                            ]
                                            );
                                        },
//                                     'update' => function($url, $model, $key){
//                                     return Html::a('<i class="fa fa-edit"></i> Edit',
//                                         Url::toRoute(['memberorganization/update','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
//                                         [
//                                             'class' => 'btn btn-primary btn-xs',
//                                         ]
//                                         );
//                                     },
                                    
//                                     'delete' => function($url, $model, $key){
//                                     return Html::a('<i class="fa fa-del"></i> Delete',
//                                         Url::toRoute(['memberorganization/delete','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
//                                         [
//                                             'class' => 'btn btn-default btn-xs',
//                                             'data' => ['confirm' => 'Are you sure to delete？',]
//                                         ]
//                                         );
//                                     },
                                    ],
                             ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

    </div>
</div>

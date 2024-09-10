<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
use backend\common\CommonStatus;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ZdeliverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zdelivers';
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
                            ['class' => 'yii\grid\SerialColumn'],
                
                            //'deliver_id',
                            //'cargo_type_id',
                            //'cargo_worth',
                            //'cargo_weight',
                            //'box_model_id',
                            //'from_member_id',
                            'from_cabinet_id',
                            ['label'=>'From Member Email',  'attribute' => 'email',  'value' => 'fromMember.email' ],
                            ['label'=>'From Member Phone',  'attribute' => 'phone',  'value' => 'fromMember.phone' ],
                            
                            //'from_box_id',
                            //'to_member_id',
                            [
                                'label'=>'To Member Email',
                                'attribute' => 'to_email',
                                'format' => 'text',
                                'value' => function($data)
                                {
                                    if(empty($data->to_member_id))
                                    {
                                        return null;
                                    }
                                    else
                                    {
                                        return $data->toMember->email;
                                    }
                                },
                            ],
                            //['label'=>'To Member Phone',  'attribute' => 'phone',  'value' => 'toMember.phone' ],
                            'to_phone',
                            'to_name',
                            'to_cabinet_id',
                            //'to_box_id',
                            //'deliver_photo_group_id',
                            'dist',
                            'fee_total',
                            'remark',
                            //'cargo_code',
                            'pick_code',
//                             [
//                                 'attribute' => 'create_time',
//                                 'format' => 'text',
//                                 'value' => function($data){return date("Y-m-d H:i:s",($data->create_time));},
//                             ],
                            //'create_time:datetime',
//                             [
//                                 'attribute' => 'update_time',
//                                 'format' => 'text',
//                                 'value' => function($data){return date("Y-m-d H:i:s",($data->update_time));},
//                             ],
                            //'update_time:datetime',
                            //'cargo_status',
                            //'status',
                            [
                                'attribute' => 'status',
                                'value'=>function ($model,$key,$index,$column){
                                           return CommonStatus::deliver_status()[$model->status];
                                         },
                                'filter' => CommonStatus::deliver_status(),
                            ],
                            //'courier_id',
                
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{View}',
                                'buttons' => [
                                    'View' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['zdeliver/view','id'=>$key]),
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

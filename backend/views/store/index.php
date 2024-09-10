<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
use backend\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores Orders List';
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
                    
                                //'store_id',
                                ['label'=>'Locker ID',  'attribute' => 'cabinet_id' ],
                    /*            [
                                    'label'=>'Courier',
                                    'attribute' => 'courier',
                                    //'value'=> empty($model->courier)? null: $model->courier->courier_name
                                    'value' => function($data)
                                    {
                                        if(empty($data->courier))
                                        {
                                            return null;
                                        }
                                        else
                                        {
                                            return $data->courier->courier_name;
                                        }
                                    },
                                ],*/
                                [
                                    'attribute' => 'tracking_no',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model)
                                    {
                                        if(empty($model->tracking_no)) return null;
                                        return strlen($model->tracking_no)>10?substr($model->tracking_no , 0 , 10):$model->tracking_no;
                                    },
                                ],
                                [
                                    'label'=>'Company',
                                    'attribute' => 'company_name',
//                                     'value' => function($data)
//                                     { var_dump($data);
//                                         if(empty($data->toMember))
//                                         {
//                                             return null;
//                                         }
//                                         else
//                                         {
//                                             return $data->toMember->unit_name;
//                                         }
//                                     },
                                ],
                                ['label'=>'Recipient', 'attribute'=>'to_member_id'],
                                ['label'=>'Recipient Email',  'attribute' => 'to_email',  'value' => function ($model) { if(empty($model->toMember))return  null;return $model->toMember->email; }, ],
                                [
                                    'label'=>'Recipient',
                                    'attribute' => 'to_phone',
                                    'value' => function ($model)
                                    {
                                        if(empty($model->to_phone)) return null;
                                        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $model->to_phone);
                                    },
                                ],
                                
                                'pick_code',
                                [
                                    'label'=>'Deposit Time',
                                    'attribute' => 'store_time',
                                    'value' => function($data)
                                    {
                                        if(empty($data->store_time))
                                        {
                                            return null;
                                        }
                                        else
                                        {
                                            return Yii::$app->formatter->asDate($data->store_time,"php:Y-m-d H:i:s");
                                        }
                                    },
                                ],
                                [
                                    'label'=>'Pickup Time',
                                    'attribute' => 'pick_time',
                                    'format' => 'text',
                                    'value' => function($data)
                                    {
                                        if(empty($data->pick_time))
                                        {
                                            return null;
                                        }
                                        else
                                        {
                                            return date("Y-m-d H:i:s",($data->pick_time));
                                        }
                                    },
                                ],
                                'pick_with',
                                [
                                    'label'=>'Remove time',
                                    'attribute' => 'clean_time',
                                    'value' => function($data)
                                    {
                                        if(empty($data->clean_time))
                                        {
                                            return null;
                                        }
                                        else
                                        {
                                            return Yii::$app->formatter->asDate($data->clean_time,"php:Y-m-d H:i:s");
                                        }
                                    },
                                ],
                                [
                                    'label'=>'Locker Open Size',
                                    'attribute' => 'model_name',
                                    'value' => function($data)
                                    {
                                        if(empty($data->box->boxmodel))
                                        {
                                            return null;
                                        }
                                        else
                                        {
                                            return $data->box->boxmodel->model_name;
                                        }
                                    },
                                ],
                                
                                [
                                    'label'=>'Storage Duration (Hours)',
                                    'value' => function($data)
                                    {
                                        if(empty($data->pick_time))
                                        {
                                            return round(((time() - $data->store_time)/3600),1);
                                        }
                                        else
                                        {
                                            return round((($data->pick_time - $data->store_time)/3600),1);
                                        }
                                    },
                                ],
                                [
                                    'label'=>'Overdue Fee',
                                    //'value' => Helper::getOverDueFee($model->store_id),
                                    'value' => function ($model)
                                    {
                                        return Helper::getOverDueFee($model->store_id);
                                    },
                                ],
                                //'cabinet_id',
                                //'box_id',
                                //'from_member_id',
//                                 [
//                                 'attribute' => 'store_time',
//                                 'format' => 'text',
//                                 'value' => function($data){return date("Y-m-d H:i:s",($data->store_time));},
//                                 ],
                                
                                //'to_member_id',
                                
                               // ['label'=>'To Member Phone',  'attribute' => 'to_phone',  'value' => function ($model) { return $model->toMember->phone; },],
                               
                                //'pick_code',
                                //'pick_expire',
                                'pick_fee',
                                
                                //'pick_with',
                                /*
                                [
                                'attribute' => 'clean_time',
                                'format' => 'text',
                                'value' => function($data){return date("Y-m-d H:i:s",($data->clean_time));},
                                ],
                                */
                                // 'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                   'header' => 'Action',
                                    'template' => '{View}',
                                    'buttons' => [
                                        'View' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-view"></i> Details',
                                            Url::toRoute(['store/view','id'=>$key]),
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

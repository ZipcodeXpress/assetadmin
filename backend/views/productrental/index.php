<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\common\CommonStatus;
use backend\models\product;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductRentalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tranaction History';
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
                                <p>
                                  <!--  <?= Html::a('Create Product Rental', ['create'], ['class' => 'btn btn-success']) ?>-->
                                </p>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                ['attribute' => 'rental_id', 'label' => 'Rental_ID',  'headerOptions' => ['width' => '80'],],
                                [
                                    'attribute' => 'email',

                                    'label' => 'Email',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model) {
                                        if (empty($model->member_id)) return null;
                                        return  $model->member->email;
                                    },
                                  
                                ],
                                ['label' => 'LockerId',  'attribute' => 'cabinet_id', 'headerOptions' => ['width' => '50'],],

                                [
                                    'attribute' => 'aptname',

                                    'label' => 'Company',
                                    'headerOptions' => ['width' => '100'],
                                    'value' => function ($model) {
                                        if (empty($model->organization_id)) return null;
                                        return  $model->organization->organization_name;
                                    },
                                  
                                ],
                             //   'organization_id',

                               // 'product_inventory_id',
                               ['attribute' => 'rfid', 'label' => 'RFID',  'headerOptions' => ['width' => '80'],],
                                
                               
                                [
                                    'attribute'=>'rental_status_code', 
                                    'headerOptions' => ['width' => '60'],
                                    'value'=>function ($model){
                                          return  CommonStatus::rental_status()[$model->rental_status_code];   
                                    },
                                    'filter' => CommonStatus::rental_status(),
                                ],

                                //['attribute' => 'rental_status_code', 'label' => 'rental_status',  'headerOptions' => ['width' => '50'],],
                               // 'rental_status_code',
                                // 'applied_deposit',
                                // 'applied_daily_fee',
                                // 'applied_sale_amt',
                                // 'applied_free_days',
                                // 'return_locker_id',
                                [
                                    'attribute'=>'product_name', 
                                    'headerOptions' => ['width' => '100'],
                                    'value'=>function ($model) {
                                       
                                        return  $model->productInventory->product->product_name;
                                    },
                           
                                ],
                                'reserve_time:datetime',
                                'rental_time:datetime',
                                'return_time:datetime',
                                [
                                    'attribute'=>'return_elapsed_days', 
                                    'label' => 'Elapsed Days',
                                    'headerOptions' => ['width' => '60'],
                                    'value'=>function ($model){
                                        if (empty($model->return_time)) return null;
                                          $elapsed_days=  $model->return_time-$model->rental_time;   
                                          return ceil(abs($elapsed_days)/86400);
                                    },
                                 
                                ],

                              //  'return_elapsed_days',
                                // 'total_charged_amt',
                                // 'Is_comment',
                                // 'Is_delete',

                                 ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'headerOptions' => ['width' => '30'],
                                'template' => '{View}',
                                'buttons' => [
                                    'View' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['productrental/view','id'=>$key]),
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
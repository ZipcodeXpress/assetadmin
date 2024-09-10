<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use backend\models\ProductInventory;
use backend\models\product;
use backend\common\CommonStatus;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductInventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title ='Product Inventory Status';
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
                                <?php if (true) : ?>
                                    <?= Html::a('Register Product Here', ['create'], ['class' => 'btn btn-primary']) ?>
                                <?php endif ?>
                            </p>
                        </div>
                    </div>
                    <?php
                    if (Yii::$app->getSession()->hasFlash('success')) {
                        echo Alert::widget([
                            'options' => [
                                'class' => 'alert alert-success', //这里是提示框的class
                            ],
                            'body' => Yii::$app->getSession()->getFlash('success'), //消息体
                        ]);
                    }
                    if (Yii::$app->getSession()->hasFlash('error')) {
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
                                ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => '40', 'height' => '40'],],
                                //      [
                                //          'attribute'=>'create_time', 
                                //           'headerOptions' => ['width' => '120'],
                                //           'value'=>function ($model,$key,$index,$column){
                                //               return empty($model->create_time)?null:date("Y-m-d H:i:s",($model->create_time));
                                //         },
                                //        'filter' => Product::getProductcategoryName(),
                                //     ],

                               
                                [
                                    'attribute' => 'ProductName',
                                    'label' => 'Product',
                                    'headerOptions' => ['width' => '50'],
                                    'value' => function ($model, $key, $index, $column) {
                                        if (empty($model->product_id)) return null;
                                        return  $model->product->product_name;
                                    },
                           //    'filter' => Product::getProductName(),
                                ],
                                [
                                    'attribute'=>'product_status_code', 
                                    'headerOptions' => ['width' => '60'],
                                    'value'=>function ($model){
                                          return  CommonStatus::product_inv_status()[$model->product_status_code];   
                                    },
                                    'filter' => CommonStatus::product_inv_status(),
                                ],
                                ['attribute' => 'rfid', 'label' => 'RFID', 'headerOptions' => ['width' => '50']],

                                ['attribute' => 'memberemail', 'label' => 'Member', 'headerOptions' => ['width' => '50'], 
                                'value' => function ($model) {
                                    if (empty($model->member_id)) return null;
                                    return  $model->member->email;
                                },
                                //    'filter' => Product::getProductName(),
                                     ],
                                [
                                    'attribute' => 'cabinet_id',
                                    'headerOptions' => ['width' => '30'],
                                    'value' =>function ($model) {
                                        if (empty($model->box_id)) return null;
                                       return $model->box->cabinet_id;
                                       
                                     },
                                    
                                ],
                            //    ['attribute' => 'product_status_code', 'headerOptions' => ['width' => '50'], ],
                                
                                ['attribute' => 'box_id', 'label' => 'column', 'headerOptions' => ['width' => '50'],
                                'value' =>function ($model) {
                                    if (empty($model->box_id)) return null;
                                   return $model->box->column;
                                   
                                 },
                            ],
                            
                            ['attribute' => 'box_id', 'label' => 'row', 'headerOptions' => ['width' => '50'],
                            'value' =>function ($model) {
                                if (empty($model->box_id)) return null;
                               return $model->box->row;
                               
                             },
                        ],
                               
                                ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'headerOptions' => ['width' => '30'],
                                'template' => '{View}',
                                'buttons' => [
                                    'View' => function($url, $model, $key){
                                        if ($model->product_status_code != 0) {
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['productinventory/view','id'=>$key]),
                                        [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]
                                        );}
                                        else {
                                            return Html::a('<i class="fa fa-view"></i> Delete',
                                            Url::toRoute(['productinventory/delete','id'=>$key]),
                                            [
                                                'class' => 'btn btn-warning btn-xs',
                                            ]
                                            );
                                        }
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
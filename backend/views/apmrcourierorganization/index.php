<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authorized Couriers';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="css/animate.min.css" rel="stylesheet">
<link href="css/style.min862f.css?v=4.1.0" rel="stylesheet">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                    <?= Html::a('Authorize A Courier', ['create'], ['class' => 'btn btn-primary']) ?>
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
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '40'],],
                                ['label'=>'Organization',  'attribute' => 'organization_name',  'value' => 'organization.organization_name','headerOptions' => ['width' => '200'], ],
                                [
                                    'label'=>'Courier Name',  
                                    'attribute' => 'courier_name',  
                                    'value' => 'courier.courier_name',
                                    'headerOptions' => ['width' => '200'], 
                                    'value'=>function ($model,$key,$index,$column)
                                    {
                                        if(empty($model->courier))
                                        {
                                            if(!empty($model->corpcourier))
                                            {
                                                return $model->corpcourier->company->company_name;
                                            }
                                            else
                                            {
                                                return null;
                                            }
                                        }
                                        else 
                                        {
                                            return $model->courier->courier_name;
                                        }
                                    },
                                ],
                                ['label'=>'Email',  'attribute' => 'email',  'value' => 'courier.email' ,'headerOptions' => ['width' => '200'],],
                                [
                                    'label'=>'Phone', 
                                    'attribute' => 'phone',  
                                    'value' => function ($model) 
                                     {
                                         if(empty($model->courier->phone))return null;
                                         return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $model->courier->phone);
                                     },
                                    'headerOptions' => ['width' => '120'], ],
                                [
                                    'label'=>'Card Code',  
                                    'attribute' => 'card_code',  
                                    'value' => 'courier.card_code',
                                    'headerOptions' => ['width' => '120'],
                                    'visible' => strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin' ? true : false,
                                    'value'=>function ($model,$key,$index,$column)
                                    {
                                        if(empty($model->courier))
                                        {
                                            if(!empty($model->corpcourier))
                                            {
                                                return $model->corpcourier->access_code;
                                            }
                                            else
                                            {
                                                return null;
                                            }
                                        }
                                        return $model->courier->card_code;
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['width' => '150'],
                                    'value'=>function ($model,$key,$index,$column)
                                    {
                                       if(empty($model->courier))
                                       {
                                            if(!empty($model->corpcourier))
                                            {
                                                return CommonStatus::courier_status()[0];
                                            }
                                            else
                                            {
                                                return null;
                                            }
                                       }
                                       return CommonStatus::courier_status()[$model->courier->status];
                                    },
                                    'filter' => CommonStatus::courier_status(),
                                ],
                                // 'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '120'],
                                    'header' => 'Action',
                                    'template' => ' {delete} ',//只需要展示删除和更新{view}
                                    //'template' => ' {update} ',//只需要展示删除和更新{view}
                                    'buttons' => [
                                        'delete' => function($url, $model, $key){
                                        return Html::button('<i class="fa fa-del"></i> Cancel Authorization',['class'=>'btn btn-danger btn-xs delete','data-courier_id'=>$model->courier_id,'data-organization_id'=>$model->organization_id]);
                                        },
//                                         'delete' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-del"></i> Delete',
//                                             Url::toRoute(['courier/delete','id'=>$key]),
//                                             [
//                                                 'class' => 'btn btn-default btn-xs',
//                                                 'data' => ['confirm' => 'Are you sure to delete？',]
//                                             ]
//                                             );
//                                         },
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
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $('.delete').click(function () { 
        var self = $(this); 
        swal({
            title: "Are you sure to cancel this authorization?",
            text: "The data cannot be restored if you deleted！",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete",
            closeOnConfirm: false
        }, function () {
       	 $.ajax({
             url: "index.php?r=apmrcourierorganization/delete",
             type: 'post',
             data: {"courier_id":self.data('courier_id'),"organization_id":self.data('organization_id'),},
             success: function (data) {
                 // do something
                 if(data.code==200)
                 {
                	 swal("Delete success！", data.msg, "success");
                	 self.parents('tr').remove();
                 }
                 else
                 {
                	 swal("Error!", data.msg, "error");
                 }
             },error:function(e){
                 alert(e.msg);
             }
         });
           
        });
    });
</script>

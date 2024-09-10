<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
use backend\models\Cabinetbodybox;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CabinetbodyboxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locker Body-Box';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="css/animate.min.css" rel="stylesheet">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                    <p>
                        <?= Html::a('Create Body Box', ['create'], ['class' => 'btn btn-primary']) ?>
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
                                ['class' => 'yii\grid\SerialColumn','headerOptions' => ['height' => '40'],],
                    
                                //['attribute' => 'body_box_id','headerOptions' => ['width' => '60'],],
                                //'body_model_id',
                                 [
                                     'label'=>'Body Model Name', 
                                     'attribute' => 'body_model_name',  
                                     'value' => 'bodymodel.model_name',
                                     'filter' => Cabinetbodybox::getBDM(), 
                                 ],
                                //'box_model_id',
                                 [   'label'=>'Box Model Name',  
                                     'attribute' => 'box_model_name',  
                                     'value' => 'boxmodel.model_name',
                                     'filter' => Cabinetbodybox::getBXM(), 
                                 ],
                                
                                ['attribute' => 'column','headerOptions' => ['width' => '120']],
                                ['attribute' => 'row','headerOptions' => ['width' => '120']],
                                ['label'=>'Lock Address',  'attribute' => 'addr','headerOptions' => ['width' => '120']],
                                //'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '120'],
                                    'header' => 'Action',
                                    'template' => ' {update} {delete} ',//只需要展示删除和更新{view}
                                    'buttons' => [
                                        'update' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-edit"></i> Edit',
                                            Url::toRoute(['cabinetbodybox/update','id'=>$key]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                            );
                                        },
                                        'delete' => function($url, $model, $key){
                                        return Html::button('Delete',['class'=>'btn btn-default btn-xs delete','data-id'=>$key]);
                                        },
//                                         'delete' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-del"></i> Delete',
//                                             Url::toRoute(['cabinetbodybox/delete','id'=>$key]),
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
            title: "Are you sure to delete?",
            text: "The data cannot be restored if you deleted！",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete",
            closeOnConfirm: false
        }, function () {
       	 $.ajax({
             url: "index.php?r=cabinetbodybox/delete",
             type: 'post',
             data: {"id":self.data('id')},
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
<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\models\Cabinetbody;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CabinetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lockers';
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
                    <?php if($IsShowCreate):?>
                        <?= Html::a('Create Locker', ['create'], ['class' => 'btn btn-primary']) ?>
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
                    
                                //'cabinet_id',
                                ['attribute'=>'cabinet_id', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'state', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'city', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'address', 'headerOptions' => ['width' => '400']],
                                ['attribute'=>'zipcode', 'headerOptions' => ['width' => '120']],
                                ['attribute'=>'service_type', 'headerOptions' => ['width' => '120']],
                                //'state',
                                //'city',
                                //'address',
                                //'zipcode',
                                // 'latitude',
                                // 'longitude',
                                // 'api_key',
                                // 'api_secret',
                                //'service_type',
                                // 'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '130'],
                                    'header' => 'Action',
                                    'template' => $template,//只需要展示删除和更新{view}
                                    'buttons' => [
                                           'update' => function($url, $model, $key){
                                                 return Html::a('<i class="fa fa-edit"></i> Edit', Url::toRoute(['cabinet/update','id'=>$key]),['class' => 'btn btn-primary btn-xs',] );
                                            },
                                           'delete' => function($url, $model, $key){
                                                return Html::button('Delete',['class'=>'btn btn-default btn-xs delete','data-id'=>$key]);
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
             url: "index.php?r=cabinet/delete",
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

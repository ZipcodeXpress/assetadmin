<?php

use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrganizationCabinetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organization Lockers Bind';
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
                       <?= Html::a('Create Organization Locker Bind', ['create'], ['class' => 'btn btn-primary']) ?>
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
                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
			    'options' => [
          			      'style'=>'word-wrap: break-word;'
        			],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '2%','height'=>'40'],],
                    
                                //'organization_id',
                                [
                                    'label'=>'Organization Name',
                                    'attribute' => 'organization_name',
                                    'headerOptions' => ['width' => '18%'],
                                    'value' => function ($model) { return $model->organization->organization_name; },
                                ],
                                ['attribute'=>'cabinet_id', 'headerOptions' => ['width' => '6%']],
                                [
                                    'label'=>'Locker Address',
                                    'attribute' => 'address',
                                    'headerOptions' => ['width' => '40%'],
                                    'value' => function ($model) { return $model->cabinet->address; },
                                ],
                                [
                                    'attribute' => 'create_time',
                                    'format' => 'text',
                                    'headerOptions' => ['width' => '18%'],
                                    'value' => function($data){return date("Y-m-d H:i:s",($data->create_time));},
                                ],
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template' => ' {update} {delete} ',//只需要展示删除和更新{view}
                                    'buttons' => [
                                        'update' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-edit"></i> Edit',
                                            Url::toRoute(['organizationcabinet/update','id'=>$key,'organization_id'=>$model->organization_id,'cabinet_id'=>$model->cabinet_id]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                            );
                                        },
                                        'delete' => function($url, $model, $key){
                                        return Html::button('Delete',['class'=>'btn btn-default btn-xs delete','data-organizationid'=>$model->organization_id,'data-cabinetid'=>$model->cabinet_id]);
                                        },
//                                         'delete' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-del"></i> Delete',
//                                             Url::toRoute(['organizationcabinet/delete','id'=>$key,'organization_id'=>$model->organization_id,'cabinet_id'=>$model->cabinet_id]),
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
             url: "index.php?r=organizationcabinet/delete",
             type: 'post',
             data: {"organization_id":self.data('organizationid'),"cabinet_id":self.data('cabinetid') },
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

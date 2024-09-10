<?php
date_default_timezone_set('America/Los_Angeles');
use yii\helpers\Html;
//use yii\grid\GridView;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Product Categories');
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
                                <?= Html::a('Create Product Category', ['create'], ['class' => 'btn btn-primary']) ?>
                            </p>
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
                        </div>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                          
                            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => '50', 'height' => '40'],],
                      //      'product_cate_id',
                            'product_cate_name',
                            ['label'=>'Company',  'attribute' => 'organization_id',  'value' => 'organization.organization_name' ],
                        
                    //        ['label'=>'123213',  'attribute' => 'organization_id',  'value' => $data->icon1, ],
                            'product_cate_desc',
             
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '120'],
                                'header' => 'Action',
                                'template' => ' {update} {delete} ', //只需要展示删除和更新{view}
                                'buttons' => [
                                    'update' => function ($url, $model, $key) {
                                        return Html::a(
                                            '<i class="	fas fa-crow"></i> Edit',
                                            Url::toRoute(['productcategory/update', 'id' => $key]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                        );
                                    },
                                    'delete' => function ($url, $model, $key) {
                                       return Html::button('Delete', ['class' => 'btn btn-default btn-xs delete', 'data-id'=>$key,'id'=>$key]);
                                    },
                                    //                                         'delete' => function($url, $model, $key){
                                      //                                       return Html::a('<i class="fa fa-del"></i> Delete',
                                     //                                            Url::toRoute(['productcategory/delete','id'=>$key]),
                                     //                                            [
                                     //                                              'class' => 'btn btn-default btn-xs',
                                     //                                               'data' => ['confirm' => 'Are you sure to delete？',]
                                     //                                          ]
                                     //                                          );
                                     //                                       },
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
    $('.delete').click(function() {
        var self = $(this);
        swal({
            title: "Are you sure to delete?",
            text: "The data cannot be restored if you deleted！"+'id',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Delete",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: "index.php?r=productcategory/delete",
                type: 'post',
                data: {
                    "id": self.data('id')
                },
                success: function(data) {
                    // do something
                    if (data.code == 200) {
                        swal("Delete success！", data.msg, "success");
                        self.parents('tr').remove();
                    } else {
                        swal("Error!", data.msg, "error");
                        
                    }
                },
                error: function(e) {
                    alert(e.msg+'112');
                }
            });

        });
    });
</script>
<?php
use yii\helpers\Html;
use backend\widgets\common\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ComplainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Complains';
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
                        ['class' => 'yii\grid\SerialColumn'],
            
                        'complain_id',
                        'member_id',
                        //'complain_photo_group_id',
                        'complain_content',
                        'process_status',
                        [
                            'attribute' => 'process_time',
                            'format' => 'text',
                            'value' => function($data)
                                       { if(empty($data->process_time)) {return null;}else { return date("Y-m-d H:i:s",($data->process_time));}},
                        ],
                        'process_by',
                        'process_remark',
                        'order_type',
                        'order_id',
                        [
                            'attribute' => 'create_time',
                            'format' => 'text',
                            'value' => function($data){if(empty($data->create_time)) {return null;}else { return date("Y-m-d H:i:s",($data->create_time));}},
                        ],
            
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => ' ',//只需要展示删除和更新{view}{update} {delete} 
                            'buttons' => [
                                       
                                ],
                        ],
                    ],
                ]); ?>
                </div>
            </div>
        </div>

    </div>
</div>
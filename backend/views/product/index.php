<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use backend\models\product;
use backend\common\CommonStatus;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
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
                                <?php if (true): ?>
                                    <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-primary']) ?>
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
                                //           'headerOptions' => ['width' => '90'],
                                //           'value'=>function ($model,$key,$index,$column){
                                //               return empty($model->create_time)?null:date("Y-m-d H:i:s",($model->create_time));
                                //         },
                                //        'filter' => Product::getProductcategoryName(),
                                //     ],
                        
                                [
                                    'attribute' => 'product_thumbnail',
                                    'format' => 'html',
                                    'label' => 'Product Photo',
                                    'headerOptions' => ['width' => '90'],
                                    'contentOptions' => ['style' => 'padding:0px 0px 0px 40px;vertical-align: middle;'],
                                    // 'value'=> function ($model,$key,$index,$column){
                                    // if(empty($model->product_thumbnail))return null;
                                    // return  '<img src="' . '/' .  . '" width="90px">&nbsp;&nbsp;&nbsp;';
                                    'value' => function ($model) {
                                            $thumbnail = trim((string) $model->product_thumbnail);
                                            if ($thumbnail === '') {
                                                return null;
                                            }

                                            if (preg_match('/^(https?:)?\/\//i', $thumbnail)) {
                                                $parts = parse_url($thumbnail);
                                                $path = isset($parts['path']) ? $parts['path'] : '';
                                                $query = isset($parts['query']) ? ('?' . $parts['query']) : '';
                                                $thumbnail = $path . $query;
                                            }

                                            $imageUrl = '/cdn-proxy/' . ltrim($thumbnail, '/');

                                            return Html::img($imageUrl, ['width' => '60px']);
                                            //return Html::img(Yii::$app->request->BaseUrl . $model->product_thumbnail, ['width' => '60px']);
                                        },
                                ],

                                [
                                    'attribute' => 'organization_id',
                                    'label' => 'Company',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model, $key, $index, $column) {
                                            if (empty($model->organization))
                                                return null;
                                            return $model->organization->organization_name;
                                        },
                                    'filter' => Product::getOrganizationName(),
                                ],
                                ['attribute' => 'product_name', 'headerOptions' => ['width' => '120']],

                                [
                                    'attribute' => 'category_id',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model, $key, $index, $column) {
                                            return (empty($model->productcategory)) ? null : $model->productcategory->product_cate_name;
                                        },
                                    'filter' => Product::getProductcategoryName(),
                                ],
                                [
                                    'attribute' => 'boxmodel_id',
                                    'label' => 'Box Size',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model, $key, $index, $column) {
                                            if (empty($model->boxmodel_id))
                                                return null;
                                            return CommonStatus::box_size()[$model->boxmodel_id];
                                        },
                                    // 'filter' => Product::getBoxmodelname(),
                                    'filter' => CommonStatus::box_size(),
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '130'],
                                    'header' => 'Action',
                                    'template' => '{update} {delete}', //只需要展示删除和更新{view}
                                    'buttons' => [
                                        'update' => function ($url, $model, $key) {
                                                return Html::a('<i class="fa fa-edit"></i> Edit', Url::toRoute(['product/update', 'id' => $key]), ['class' => 'btn btn-primary btn-xs',]);
                                            },

                                        'delete' => function ($url, $model, $key) {
                                                return Html::a(
                                                    '<i class="fa fa-del"></i> Delete',
                                                    Url::toRoute(['product/delete', 'id' => $key]),
                                                    [
                                                        'class' => 'btn btn-default btn-xs',
                                                        'data' => ['confirm' => 'Are you sure to delete？',]
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
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use frontend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MemberaddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Member Address List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                    </div>
                

                    <div class="table-responsive">
                   <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                    
                                //'address_id',
                                //'member_id',
                                ['label'=>'Email',  'attribute' => 'email',  'value' => 'member.email' ],
                                ['label'=>'Phone',  'attribute' => 'phone',  'value' => 'member.phone' ],
                                'first_name',
                                'last_name',
                                'state',
                                'city',
                                'address',
                                'longitude',
                                'latitude',
                                'zipcode',
                                // 'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template' => ' {update} ',//只需要展示删除和更新{view}{delete} 
                                    'buttons' => [
                                        'update' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-edit"></i> Edit',
                                            Url::toRoute(['memberaddress/update','id'=>$key]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                            );
                                        },
//                                         'delete' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-del"></i> Delete',
//                                             Url::toRoute(['memberaddress/delete','id'=>$key]),
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

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\WalletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wallets';
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
                    </div>
                    </div>
                

                    <div class="table-responsive">
                   <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                
                            //'member_id',
                            ['label'=>'Member Email',  'attribute' => 'email',  'value' => 'member.email' ],
                            ['label'=>'Member Phone',  'attribute' => 'phone',  'value' => 'member.phone' ],
                            'money',
                            'frozen_money',
                            'ubi',
                
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'view' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-view"></i> Details',
                                        Url::toRoute(['wallet/view','id'=>$key]),
                                        [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]
                                        );
                                    },
                                    'update' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-edit"></i> Edit',
                                        Url::toRoute(['wallet/update','id'=>$key]),
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
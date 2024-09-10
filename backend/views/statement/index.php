<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Statements Of Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                    
                                //'statement_id',
                                //'member_id',
                                ['label'=>'Member Email',  'attribute' => 'email',  'value' => 'member.email' ],
                                [
                                    'label'=>'Member Phone',
                                    'attribute' => 'phone', 
                                    'value' => function ($model) 
                                     {
                                         return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $model->member->phone);
                                     },
                                ],
                                'statement_type',
                                'statement_desc',
                                'amount',
                                'money',
                                'frozen_money',
                                'ubi',
                                'channel',
                                'extra',
                                'order_id',
                                // 'order_payment_id',
                                // 'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template' => '{View}',
                                    'buttons' => [
                                        'View' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-view"></i> Details',
                                            Url::toRoute(['statement/view','id'=>$key]),
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

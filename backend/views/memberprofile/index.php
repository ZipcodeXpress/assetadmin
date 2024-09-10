<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberprofileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Memberprofiles';
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
                    <!--<?= Html::a('Create Organizations', ['create'], ['class' => 'btn btn-primary']) ?>-->
                    </div>
                    </div>
                

                    <div class="table-responsive">
                   <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                    
                                //'member_id',
                                ['label'=>'Email',  'attribute' => 'email',  'value' => 'member.email' ],
                                ['label'=>'Phone',  'attribute' => 'phone',  'value' => 'member.phone' ],
                                'nick_name',
                                'first_name',
                                'last_name',
                                'addressline1',
                                'addressline2',
                                 'city',
                                 'state',
                                 'zipcode',
                                 'phone',
                                 'birth',
                                // 'sex',
                                // 'avatar',
                                // 'profile_id',
                                // 'create_time:datetime',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'template' => ' {update} ',//只需要展示删除和更新{view}{delete} 
                                    'buttons' => [
                                        'update' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-edit"></i> Edit',
										    //Url::toRoute(['memberprofile/update','member_id'=>$model->member_id,'organization_id'=>$model->organization_id,'cancel_time'=>$model->cancel_time]),
                                            Url::toRoute(['memberprofile/update','id'=>$key]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                            );
                                        },
//                                         'delete' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-del"></i> Delete',
//                                             Url::toRoute(['memberprofile/delete','id'=>$key]),
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
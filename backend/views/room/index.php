<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rooms';
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
                    <?= Html::a('Create Room', ['create'], ['class' => 'btn btn-primary']) ?>
                    </div>
                    </div>

                    <div class="table-responsive">
                   <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //'building_id',
                            ['label'=>'Building',  'attribute' => 'building_name',  'value' => 'building.building_name' ],
                            'room_id',
                            'room_name',
                            'floor',
                            'unit',
                            // 'create_time:datetime',
                
                            ['class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => ' {update} {delete} ',//只需要展示删除和更新{view}
                                'buttons' => [
                                    'update' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-edit"></i> Edit',
                                        Url::toRoute(['room/update','id'=>$key]),
                                        [
                                            'class' => 'btn btn-primary btn-xs',
                                        ]
                                        );
                                    },
                                    'delete' => function($url, $model, $key){
                                    return Html::a('<i class="fa fa-del"></i> Delete',
                                        Url::toRoute(['room/delete','id'=>$key]),
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
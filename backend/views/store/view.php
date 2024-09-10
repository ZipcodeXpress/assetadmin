<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\Helper;

/* @var $this yii\web\View */
/* @var $model backend\models\Store */

$this->title = "Orders ID: ".$model->store_id;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
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
                   <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'store_id',
                            ['label'=>'Locker ID','attribute'=>'cabinet_id'],
                            ['label'=>'Courier','value'=> empty($model->courier)? null: $model->courier->courier_name],
                            'tracking_no',
                            ['label'=>'Unit#','value'=> empty($model->toMember->unit_name)?null:$model->toMember->unit_name,],
                            ['label'=>'Recipient', 'attribute'=>'to_member_id'],
                            ['label'=>'Recipient Email','value'=>$model->toMember->email,],
                            ['label'=>'Recipient Phone','value'=>$model->toMember->phone,],
                            
                            'pick_code',
                            [
                                'label'=>'Deposit Time',
                                'value' => empty($model->store_time)? null: Yii::$app->formatter->asDate($model->store_time,"php:Y-m-d H:i:s"),
                            ],
                            [
                                'label'=>'Pickup Time',
                                'value' =>  empty($model->pick_time)? null:Yii::$app->formatter->asDate($model->pick_time,"php:Y-m-d H:i:s"),
                            ],
                            'pick_with',
                            [
                                'label'=>'Remove time',
                                'value' => empty($model->clean_time)? null: Yii::$app->formatter->asDate($model->clean_time,"php:Y-m-d H:i:s"),
                            ],
                            ['label'=>'Locker Open Size','value'=> empty($model->box->boxmodel)?null:$model->box->boxmodel->model_name,],
                            
                            [
                                'label'=>'Storage Duration (Hours)',
                                'value' => empty($model->pick_time)? round(((time() - $model->store_time)/3600),1):round((($model->pick_time - $model->store_time)/3600),1),
                            ],
                            [
                                'label'=>'Overdue Fee',
                                'value' => Helper::getOverDueFee($model->store_id),
                            ],
                            //'cabinet_id',
                            //'from_member_id',
                            //['label'=>'From Memeber Email','value'=>empty($model->member)?null:$model->member->email,],
                            //['label'=>'From Member Phone','value'=>empty($model->member)?null:$model->member->phone,],
                            //'box_id',
                            
                            //'store_time:datetime',
                            //'to_phone',
                           
                            //'pick_expire',
                            'pick_fee',
                            
                            //'pick_time:datetime',
                           
                            
                            //[
                            //'label'=>'create time',
                            //'value' =>  Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
                            //],
                            //'clean_time:datetime',
                            //'create_time:datetime',
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

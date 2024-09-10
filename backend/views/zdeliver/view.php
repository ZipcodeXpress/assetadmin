<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Zdeliver */

$this->title = "Deliver Details: ".$model->deliver_id;
$this->params['breadcrumbs'][] = ['label' => 'Zdelivers', 'url' => ['index']];
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
                            'deliver_id',
                            'cargo_type_id',
                            'cargo_worth',
                            'cargo_weight',
                            'box_model_id',
                            'from_member_id',
                            ['label'=>'From Member Email',  'value' => $model->fromMember->email],
                            ['label'=>'From Member Phone',  'value' => $model->fromMember->phone],
                            'from_cabinet_id',
                            'from_box_id',
                            'to_member_id',
                            [
                                'label'=>'To Member Email',
                                'format' => 'text',
                                'value' =>$model->toMember==null? null:$model->toMember->email,
                            ],
                            [
                                'label'=>'To Member Phone',
                                'format' => 'text',
                                'value' => $model->toMember==null? null:$model->toMember->phone,
                            ],
                            //['label'=>'to Member Email',  'value' => $model->toMember->email],
                            //['label'=>'to Member Phone',  'value' => $model->toMember->phone],
                            'to_phone',
                            'to_name',
                            'to_cabinet_id',
                            'to_box_id',
                            'deliver_photo_group_id',
                            'dist',
                            'fee_total',
                            'remark',
                            'cargo_code',
                            'pick_code',
                            [
                                'label'=>'Create Time',
                                'value' =>  Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
                            ],
                            //'create_time:datetime',
                            //'update_time:datetime',
                            [
                                'label'=>'Update Time',
                                'value' =>  Yii::$app->formatter->asDate($model->update_time,"php:Y-m-d H:i:s"),
                            ],
                            //'status',
                            [
                                'label'=>'Status',
                                'value'=>CommonStatus::deliver_status()[$model->status],
                            ],
                            'courier_id',
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

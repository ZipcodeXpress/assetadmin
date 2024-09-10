<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierapply */

$this->title = "ZXP Courier Application Details: ".$model->apply_id;
$this->params['breadcrumbs'][] = ['label' => 'Zcourierapplies', 'url' => ['index']];
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
                            'apply_id',
                            'courier_id',
                            ['label'=>'Email',  'value' => $model->member->email],
                            ['label'=>'Phone',  'value' => $model->member->phone],
                            [
                                'label'=>'apply time',
                                'value' =>  Yii::$app->formatter->asDate($model->apply_time,"php:Y-m-d H:i:s"),
                            ],
                            [
                                'label'=>'process time',
                                'value' =>  Yii::$app->formatter->asDate($model->process_time,"php:Y-m-d H:i:s"),
                            ],
                            'process_result',
                            [
                                'label'=>'process result',
                                'value'=>CommonStatus::proces_result_status()[$model->process_result],
                            ],
                            //'process_by',
                            ['label'=>'Email',  'value' => empty($model->processMember)?null:$model->processMember->username],
                            'remark',
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

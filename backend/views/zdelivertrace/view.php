<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Zdelivertrace */

$this->title = "Deliver Trace Details: ".$model->trace_id;
$this->params['breadcrumbs'][] = ['label' => 'Zdelivertraces', 'url' => ['index']];
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
                            'trace_id',
                            'deliver_id',
                            //'create_time:datetime',
                            'trace',
                            'desc',
                            [
                            'label'=>'create time',
                            'value' =>  Yii::$app->formatter->asDate($model->create_time,"php:Y-m-d H:i:s"),
                            ],
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>
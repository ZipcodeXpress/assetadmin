<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Zcourier */

$this->title = $model->courier_id;
$this->params['breadcrumbs'][] = ['label' => 'Zcouriers', 'url' => ['index']];
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
                            'courier_id',
                            ['label'=>'Email','value'=>$model->member->email,],
                            ['label'=>'Phone','value'=>$model->member->phone,],
                            'credit_rating',
                            'grade',
                            'user_rating',
                            'total_orders',
                            'bad_orders',
                            //'is_signed',
                            ['label'=>'is_signed','value'=>$model->is_signed==1? "Signed":"Not signed",],
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>
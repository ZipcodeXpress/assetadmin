<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OrganizationCabinet */

$this->title = $model->organization_id;
$this->params['breadcrumbs'][] = ['label' => 'Organization Cabinets', 'url' => ['index']];
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
                            'organization_id',
                            'cabinet_id',
                            'create_time:datetime',
                        ],
                    ]) ?>
                    </div>
                     <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

    </div>
</div>

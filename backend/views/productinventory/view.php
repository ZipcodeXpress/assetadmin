<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductInventory */

$this->title = $model->product_inventory_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Inventories', 'url' => ['index']];
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
                        <p>
                            <?= Html::a('Update', ['update', 'id' => $model->product_inventory_id], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Delete', ['delete', 'id' => $model->product_inventory_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </p>

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'product_inventory_id',
                                [
                                    'attribute' => 'ProductName',
                                    'label' => 'Product',
                                   
                                    'value' => function ($model) {
                                        if (empty($model->product_id)) return null;
                                        return  $model->product->product_name;
                                    },
                        
                                ],
                                'cabinet_id',
                            
                                [
                                    'attribute' => 'Organization Name',
                                    'label' => 'Organization Name',
                                   
                                    'value' => function ($model) {
                                        if (empty($model->organization_id)) return null;
                                        return  $model->organization->organization_name;
                                    },
                        
                                ],
                                ['attribute' => 'member_id','label' => 'Member Name','value'=>function ($model) {
                                    if (empty($model->member_id)) return null;
                                    return  $model->member->email;},],
                                ['attribute' => 'column','value'=>function ($model) {
                                    if (empty($model->box)) return null;
                                    return $model->box->column;},],
                              
                                ['attribute' => 'row','value'=>function ($model) {
                                    if (empty($model->box)) return null;
                                    return $model->box->row;}],
                                'rfid',
                                
                               [ 'attribute' => 'product_status_code',
                                   'value'=>CommonStatus::product_inv_status()[$model->product_status_code]],
                              //  'product_service_type',
                            ],
                         
                        ]) ?>

                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>RFID</th>
                                    <th>Pickupcode</th>
                                    <th>email</th>
                                    <th>Rental Status</th>
                                    <th>Reserve Time</th>
                                    <th>Rental Time</th>
                                    <th>Return Time</th>
                                    <th>Elapsed days</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($productrental)) : ?>
                                    <tr>
                                        <td colspan="8"><?= Yii::t('common', 'No record found.') ?> </td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($productrental as $rental) : ?>
                                        <tr>
                                            <th><?= $rental->organization->organization_name ?></th>
                                            <th><?= $rental->rfid ?></th>
                                            <th><?= $rental->pickup_code ?></th>
                                            <th><?= $rental->member->email ?></th>
                                            <th><?=  CommonStatus::rental_status()[$rental->rental_status_code] ?></th>
                                            <th><?= Yii::$app->formatter->asDate($rental->reserve_time,"php:Y-m-d H:i:s") ?></th>
                                            
                                            <th><?=  Yii::$app->formatter->asDate($rental->rental_time,"php:Y-m-d H:i:s")?></th>
                                            <th><?=  Yii::$app->formatter->asDate($rental->return_time,"php:Y-m-d H:i:s")?></th>
                                            <th><?= ceil(abs(($rental->return_time-$rental->rental_time)/86400)) ?></th>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>

    </div>
</div>
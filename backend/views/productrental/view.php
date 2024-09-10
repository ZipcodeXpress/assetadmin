<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\common\CommonStatus;
use backend\models\product;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductRental */

$this->title = $model->rental_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Rentals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-rental-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rental_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rental_id], [
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
            'rental_id',
            [
           
                'label' => 'Company',
               
                'value' => function ($model) {
                    if (empty($model->organization_id)) return null;
                    return  $model->organization->organization_name;
                },
              
            ],
            'cabinet_id',
            'product_inventory_id',
            [
                'attribute'=>'product_name', 
                'headerOptions' => ['width' => '100'],
                'value'=>function ($model) {
                   
                    return  $model->productInventory->product->product_name;
                },
       
            ],
            'rfid',
            'member_id',
            [
           
                'label' => 'member_email',
               
                'value' => function ($model) {
                    if (empty($model->member_id)) return null;
                    return  $model->member->email;
                },
              
            ],
            'pickup_code',
            'reserve_time:datetime',
            'expire_time:datetime',
            'rental_time:datetime',
            'return_time:datetime',
            
            //'rental_status_code',
           
            [
                'attribute'=>'return_elapsed_days', 
                'headerOptions' => ['width' => '60'],
                'value'=>function ($model){
                    if (empty($model->return_time)) return null;
                      $elapsed_days=  $model->return_time-$model->rental_time;   
                      return ceil(abs($elapsed_days)/86400);
                },
             
            ],
            ['attribute' => 'rental_status_code', 'value'=>function ($model){
                return  CommonStatus::rental_status()[$model->rental_status_code]; }],
           
        ],
    ]) ?>

</div>

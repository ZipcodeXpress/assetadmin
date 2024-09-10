<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductInventory */

$this->title = 'Update Product Inventory: ' . $model->product_inventory_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_inventory_id, 'url' => ['view', 'id' => $model->product_inventory_id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="col-sm-12">
    <div class="ibox">
        <div class="ibox-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="ibox-content">

            <?=
           
             $this->render('_form', [
                'model' => $model,
                'product' => $product,
                'organizations' => $organizations,
                'productrental' => $productrental,
                
            ]) ?>


            <div class="table-responsive">
            <table class="table">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>RFID</th>
                                    <th>Pickupcode</th>
                                    <th>email</th>
                                    <th>Rental Status</th>
                                    <th>Rental Time</th>
                                    <th>Rental Elapsed Days</th>
                                    <th>Z</th>
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
                                            <th><?= $rental->organization_id ?></th>
                                            <th><?= $rental->rfid ?></th>
                                            <th><?= $rental->pickup_code ?></th>
                                            <th><?= $rental->member->email ?></th>
                                            <th><?= $rental->rental_status_code ?></th>
                                            <th><?= $rental->rental_time ?></th>
                                            <th><?= $rental->return_elapsed_days?></th>
                                            <th><?= $rental->member_id ?></th>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
            </div>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
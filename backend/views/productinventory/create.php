<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductInventory */

$this->title = 'Product Register to Inventory';
$this->params['breadcrumbs'][] = ['label' => 'Product Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= 
   Breadcrumbs::widget([
      'homeLink' => [ 
                      'label' => Yii::t('yii', 'Dashboard'),
                      'url' => Yii::$app->homeUrl,
                 ],
      'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
   ]) 
?>

<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>
            
            <?= $this->render('_form', [
                'model' => $model,
                'product' => $product,
                'organizations' => $organizations,
                'inistatuscode'=>$inistatuscode,
                'formtype' =>1,
            ]) ?>
        </div>
    </div>
</div>

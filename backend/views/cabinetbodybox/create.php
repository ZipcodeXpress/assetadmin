<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cabinetbodybox */

$this->title = 'Create Locker Body Box Relation';
$this->params['breadcrumbs'][] = ['label' => 'Cabinet Body Boxes Relation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
           <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'bodymodel' => $bodymodel,
        'boxmodel'=>$boxmodel,
    ]) ?>
        </div>
    </div>
</div>

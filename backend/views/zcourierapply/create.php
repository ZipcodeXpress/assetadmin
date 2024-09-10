<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierapply */

$this->title = 'Create Zcourierapply';
$this->params['breadcrumbs'][] = ['label' => 'Zcourierapplies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zcourierapply-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

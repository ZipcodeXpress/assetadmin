<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Zcourierorder */

$this->title = 'Create Zcourierorder';
$this->params['breadcrumbs'][] = ['label' => 'Zcourierorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zcourierorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

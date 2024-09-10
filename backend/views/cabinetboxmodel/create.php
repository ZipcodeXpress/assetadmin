<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CabinetBoxModel */

$this->title = 'Create Box Model';
$this->params['breadcrumbs'][] = ['label' => 'Locker Box Model', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="user-create">
        <div class="ibox-content">
            <h1><?= Html::encode($this->title) ?></h1>

            <hr/>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

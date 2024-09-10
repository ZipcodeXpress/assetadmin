<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;
use yii\widgets\ActiveForm;
use backend\common\CommonStatus;


/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = 'Update Member: ' . ' ' . $model->member_id;
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="css/animate.min.css" rel="stylesheet">
<link href="css/style.min862f.css?v=4.1.0" rel="stylesheet">
<div class="col-sm-12">
    <div class="ibox">
        <div class="ibox-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Member</a>
                        </li>
                        <?php if(strtolower(Yii::$app->user->identity->usergroup['item_name'])=='superadmin'):?>
                        <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Wallet</a>
                        </li>
                        <?php endif ?>
                         <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="true">Member Profile</a>
                        </li>
                        <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false">Member Address</a>
                        </li>
                         <li class=""><a data-toggle="tab" href="#tab-5" aria-expanded="false">Member Organization</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                 <?= $this->render('_form', [
                                        'model' => $model,
                                        'statusModel'=>$statusModel,
                                        'cstatusModel'=>$cstatusModel
                                 ]) ?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                             <?= $this->render('../wallet/_form', [
                                        'model' => $walletModel,
                                    ]) ?>
                            </div>
                        </div>
                        <div id="tab-3" class="tab-pane">
                            <div class="panel-body">
                             <?=$this->render('../memberprofile/_form', [
                                     'model' => $memberProfileModel,
                                     'memberModel'=>$model,
                                 ]);
                                 ?>
                            </div>
                        </div>
                        <div id="tab-4" class="tab-pane">
                            <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Longitude</th>
                                        <th>Latitude</th>
                                        <th>Zipcode</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php if ( empty($memberAddressModel)): ?>
                                            <tr ><td colspan ="8"><?=Yii::t('common' ,'No address found.') ?> </td ></tr >
                                        <?php else: ?>
                                            <?php foreach ($memberAddressModel as $address):?>
                                                <tr>
                                                     <th><?=$address->first_name?></th>
                                                     <th><?=$address->last_name?></th>
                                                     <th><?=$address->state?></th>
                                                     <th><?=$address->city?></th>
                                                     <th><?=$address->address?></th>
                                                     <th><?=$address->longitude?></th>
                                                     <th><?=$address->latitude?></th>
                                                     <th><?=$address->zipcode?></th>
                                                 </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab-5" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Member ID</th>
                                        <th>Member Email</th>
                                        <th>Member Phone</th>
                                        <th>Organization</th>
                                        <th>Business Unit</th>
                                        <th>Approve_Time</th>
                                        <th>approve_status</th>
                                        <th>charge_day</th>
                                        <th>price</th>
                                        <th>cost</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php if ( empty($memberOrganizationModel)): ?>
                                            <tr ><th colspan ="11"><?=Yii::t('common' ,'No organizations binded this member.') ?> </th ></tr >
                                        <?php else: ?>
                                            <?php foreach ($memberOrganizationModel as $organization):?>
                                                <tr>
                                                    <th><?=$organization->member_id?></th>
                                                    <th><?=$organization->member->email?></th>
                                                    <th><?=$organization->member->phone?></th>
                                                    <th><?=$organization->organization->organization_name?></th>
                                                    <th><?=$organization->member->unit_name?></th>
                                                    <th><?=date("Y-m-d H:i:s",($organization->approve_time))?></th>
                                                    <th><?=CommonStatus::member_organization_approve_status()[$organization->approve_status]?></th>
                                                    <th><?=$organization->charge_day?></th>
                                                    <th><?=$organization->price?></th>
                                                    <th><?=$organization->cost?></th>
                                                    <th><?=CommonStatus::member_organization_status()[$organization->status]?></th>
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
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
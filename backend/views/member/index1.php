<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\widgets\common\GridView;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-12">
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li id="tab_member" class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Members</a>
                        </li>
                        <li id="tab_import" class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Import Member</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                             <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '40'],],
                                [
                                    'attribute' => 'first_name',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model)
                                    {
                                        if(empty($model->profile->first_name)) return  null;
                                        return $model->profile->first_name;
                                    },
                                ],
                                [
                                    'attribute' => 'last_name',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model)
                                    {
                                        if(empty($model->profile->last_name)) return  null;
                                        return $model->profile->last_name;
                                    },
                                ],
                    
                                ['attribute' => 'email','headerOptions' => ['width' => '200'],],
                                [
                                    'attribute' => 'phone',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model) 
                                     {
                                         return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/","($1) $2-$3", $model->phone);
                                     },
                                ],
                                //'email:email',
                                //'phone',
                                //'password',
                                //'salt',
                                // 'register_time:datetime',
                                // 'lastlogin_time:datetime',
                                // 'last_ip',
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['width' => '200'],
                                    'value'=>function ($model,$key,$index,$column){
                                        return CommonStatus::member_status()[$model->status];
                                    },
                                    'filter' => CommonStatus::member_status(),
                                ],
                                [
                                    'attribute' => 'unit_name',
                                    'headerOptions' => ['width' => '120'],
                                    'value' => function ($model)
                                    {
                                        if(empty($model->unit_name)) return null;
                                        return $model->unit_name;
                                    },
                                ],
//                                 [
//                                     'attribute' => 'c_status',
//                                     'headerOptions' => ['width' => '300'],
//                                     'value'=>function ($model,$key,$index,$column){
//                                         return CommonStatus::member_c_status()[$model->c_status];
//                                     },
//                                     'filter' => CommonStatus::member_c_status(),
//                                 ],
                                [   
                                    'attribute' => 'is_email_verified',
                                    'headerOptions' => ['width' => '120'],
                                    'value'=>function ($model,$key,$index,$column){
                                                 return $model->is_email_verified==1?'Verified':'Not Verified';
                                             },
                                    'filter' => ['1'=>'Verified','0'=>'Not Verified'],
                                 ],
                                 [
                                     'attribute' => 'is_profile_completed',
                                     'headerOptions' => ['width' => '120'],
                                     'value'=>function ($model,$key,$index,$column){
                                     return $model->is_profile_completed==1?'Completed':'Not Completed';
                                     },
                                     'filter' => ['1'=>'Completed','0'=>'Not Completed'],
                                 ],
                                 [
                                     'attribute' => 'has_credit_card',
                                     'headerOptions' => ['width' => '80'],
                                     'value'=>function ($model,$key,$index,$column){
                                     return $model->has_credit_card==1?'Yes':'No';
                                     },
                                     'filter' => ['1'=>'Yes','0'=>'No'],
                                 ],
                                // 'cabinet_id',
                                // 'service_mode',
                    
                                ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '120'],
                                    'header' => 'Action',
                                    'template' => ' {update} {bind}',//只需要展示删除和更新 {address} {profile} {view} {delete} 
                                    'buttons' => [
//                                         'address' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-edit"></i> Address',
//                                             Url::toRoute(['memberaddress/index','member_id'=>$key]),
//                                             [
//                                                 'class' => 'btn btn-primary btn-xs',
//                                             ]
//                                             );
//                                         },
//                                         'profile' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-edit"></i> Profile',
//                                             Url::toRoute(['memberprofile/index','member_id'=>$key]),
//                                             [
//                                                 'class' => 'btn btn-primary btn-xs',
//                                             ]
//                                             );
//                                         },
                                        'update' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-edit"></i> Edit',
                                            Url::toRoute(['member/update','id'=>$key]),
                                            [
                                                'class' => 'btn btn-primary btn-xs',
                                            ]
                                            );
                                        },
                                        'bind' => function($url, $model, $key){
                                        return Html::a('<i class="fa fa-unlock-alt"></i> Bind',
                                            Url::toRoute(['memberorganization/create','id'=>$key]),
                                            [
                                                'class' => 'btn btn-warning btn-xs',
                                            ]
                                            );
                                        },
//                                         'delete' => function($url, $model, $key){
//                                         return Html::a('<i class="fa fa-del"></i> Delete',
//                                             Url::toRoute(['member/delete','id'=>$key]),
//                                             [
//                                                 'class' => 'btn btn-default btn-xs',
//                                                 'data' => ['confirm' => 'Are you sure to delete？',]
//                                             ]
//                                             );
//                                         },
                                        ],
                                ],
                            ],
                        ]); ?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                            <div class="form-group">
                                <h3>Please use this template to import. <a href="template/member-template.csv">Download</a></h3>
                            </div>
                            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                              <?= $form->field($model, 'file')->fileInput() ?>
                              <?= $form->field($model, 'organization_id' )->dropDownList($organizationModel)?>
                            <div class="form-group">
                                <?= Html::submitButton('Import', ['class' =>'btn btn-primary upload','id'=>"buttonUpload"]) ?>
                                <?= Html::a('Back', ['index'], ['class' => 'btn btn-success']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
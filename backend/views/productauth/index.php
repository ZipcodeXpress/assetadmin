<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use backend\common\CommonStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductAuthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Authorization';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">

    <div class="ibox-content">
        <div class="row">
            <div class="col-sm-6 m-b-xs">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <p>
                    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
         //       'product_name',
         ['attribute' => 'product_id', 'label' => 'Product ID', 'headerOptions' => ['width' => '100'], 
         'value' => function ($model) {
             if (empty($model->product_id)) return null;
             return  $model->product_id;
         },
     ],     
         ['attribute' => 'product_name', 'label' => 'Product_name', 'headerOptions' => ['width' => '400'], 
         'value' => function ($model) {
             if (empty($model->product_id)) return null;
             return  $model->product->product_name;
         },
     ],     
     ['attribute' => 'org_name', 'label' => 'Organization_name', 'headerOptions' => ['width' => '400'], 
     'value' => function ($model) {
         if (empty($model->organization_id)) return null;
         return  $model->organization->organization_name;
     },
 ],     
      //   'product_id',
  
       //         'auth_code',
                ['attribute' => 'member_firstname', 'label' => 'Member First Name', 'headerOptions' => ['width' => '200'], 
                'value' => function ($model) {
                    if (empty($model->member_id)) return null;
                    return  $model->profile->first_name;
                },
            ],
            ['attribute' => 'member_lastname', 'label' => 'Member Last Name', 'headerOptions' => ['width' => '200'], 
            'value' => function ($model) {
                if (empty($model->member_id)) return null;
                return  $model->profile->last_name;
            },
        ],
        [
            'attribute' => 'approve_status',
            'headerOptions' => ['width' => '120'],
            'value'=>function ($model,$key,$index,$column){
                return  CommonStatus::member_product_approve_status()[$model->approve_status];
            },
            'filter' => CommonStatus::member_product_approve_status(),
        ],
        [
            'attribute' => 'auth_code',
            'headerOptions' => ['width' => '120'],
            'value'=>function ($model,$key,$index,$column){
            return  CommonStatus::member_product_status()[$model->auth_code];
            },
            'filter' => CommonStatus::member_product_status(),
        ],
        ['class' => 'yii\grid\ActionColumn',
        'headerOptions' => ['width' => '120'],
        'header' => 'Action',
        'template' => '{approve} {delete}',//只需要展示删除和更新{view}
        'buttons' => [
                'approve' => function($url, $model, $key){
                    if($model->approve_status==1)
                    {
                        if($model->auth_code==3)
                        {
                            return Html::a('<i class="fa fa-edit"></i>  Recovery',
                                Url::toRoute(['productauth/approve','product_id'=>$model->product_id,'member_id'=>$model->member_id]),
                                [
                                    'class' => 'btn btn-danger btn-xs',
                                    'data' => ['confirm' => 'Are you sure to recover this user？',]
                                ]
                                );
                        }
                        else 
                        {
                            return Html::a('<i class="fa fa-edit"></i>  Cancel',
                                Url::toRoute(['productauth/approve','product_id'=>$model->product_id,'member_id'=>$model->member_id]),
                                [
                                    'class' => 'btn btn-danger btn-xs',
                                    'data' => ['confirm' => 'Are you sure to cancel this user？',]
                                ]
                                );
                        }
                    }
                    else 
                    {
                        return Html::a('<i class="fa fa-edit"></i> Approve',
                            Url::toRoute(['productauth/approve','product_id'=>$model->product_id,'member_id'=>$model->member_id]),
                            [
                               'class' => 'btn btn-primary btn-xs',
                                'data' => ['confirm' => 'Are you sure to approve this user？',]
                            ]
                            );
                    }
                },
               'delete' => function($url, $model, $key){
                return Html::a('<i class="fa fa-edit"></i> Delete',
                    Url::toRoute(['productauth/delete','product_id'=>$model->product_id,'member_id'=>$model->member_id]),
                 [
                       'class' => 'btn btn-warning btn-xs',
                    ]
                   );
              },
            ],
        ],
            ],
        ]); ?>
    </div>
</div>
<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Admin Users';

?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                        <a class="btn btn-info btn-sm" href="<?= Url::toRoute('user/create')?>">Create Admin</a>
                    </div>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>AdminName</th>
                                <th>AdmninGroup</th>
                                <th>Email</th>
                                <th>CreateTime</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($user as $vo):?>
                                <tr>
                                    <td><?=$vo['id']?></td>
                                    <td><?=$vo['username']?></td>
                                    <td><?=$vo['usergroup']['item_name']?></td>
                                    <td><?=$vo['email']?></td>
                                    <td><?=date('Y-m-d H:i:s',$vo['created_at'])?></td>
                                    <td><a class="btn btn-primary btn-xs" href="<?=Url::toRoute(['user/update','item_name'=>$vo['usergroup']['item_name'],'id'=>$vo['id']])?>"><i class="fa fa-edit"></i>Edit</a>  <?php if($vo['username'] !='admin'):?><a href="<?=Url::toRoute(['user/delete','id'=>$vo['id']])?>" class="btn btn-default btn-xs"><i class="fa fa-close"></i>Delete</a><?php endif;?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <!--分页-->
                        <div class="f-r">
                            <?= LinkPager::widget([
                                'pagination'=>$pages,
                                'firstPageLabel' => 'Index',
                                'nextPageLabel' => 'Next',
                                'prevPageLabel' => 'Pre',
                                'lastPageLabel' => 'Last',
                            ]) ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\widgets\common\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
           
            <p>
            </p>

        </div>

    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Organization Room Count</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">选项1</a>
                                    </li>
                                    <li><a href="#">选项2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
    
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Organization ID</th>
                                        <th>数据</th>
                                        <th>Organization Name</th>
                                        <th>Room Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach($rooms as $r):?>
                                    <tr>
                                         <tr>
                                            <td><?=$r['organization_id']?></td>
                                            <td><span class="line" style="display: none;">5,3,2,-1,-3,-2,2,3,5,2</span><svg class="peity" height="16" width="32"><polygon fill="#1ab394" points="0 9.375 0 0.5 3.5555555555555554 4.25 7.111111111111111 6.125 10.666666666666666 11.75 14.222222222222221 15.5 17.77777777777778 13.625 21.333333333333332 6.125 24.888888888888886 4.25 28.444444444444443 0.5 32 6.125 32 9.375"></polygon><polyline fill="transparent" points="0 0.5 3.5555555555555554 4.25 7.111111111111111 6.125 10.666666666666666 11.75 14.222222222222221 15.5 17.77777777777778 13.625 21.333333333333332 6.125 24.888888888888886 4.25 28.444444444444443 0.5 32 6.125" stroke="#169c81" stroke-width="1" stroke-linecap="square"></polyline></svg>
                                            </td>
                                            <td><?=$r['organization_name']?></td>
                                            <td class="text-navy">  <?=$r['room_count']?></td>
                                        </tr>
                                    </tr>
                                 <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Organization Member Count</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="table_basic.html#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="table_basic.html#">选项1</a>
                                    </li>
                                    <li><a href="table_basic.html#">选项2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
    
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Organization ID</th>
                                        <th>数据</th>
                                        <th>Organization Name</th>
                                        <th>Member Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($members as $r):?>
                                    <tr>
                                         <tr>
                                            <td><?=$r['organization_id']?></td>
                                            <td><span class="line" style="display: none;">5,3,2,-1,-3,-2,2,3,5,2</span><svg class="peity" height="16" width="32"><polygon fill="#1ab394" points="0 9.375 0 0.5 3.5555555555555554 4.25 7.111111111111111 6.125 10.666666666666666 11.75 14.222222222222221 15.5 17.77777777777778 13.625 21.333333333333332 6.125 24.888888888888886 4.25 28.444444444444443 0.5 32 6.125 32 9.375"></polygon><polyline fill="transparent" points="0 0.5 3.5555555555555554 4.25 7.111111111111111 6.125 10.666666666666666 11.75 14.222222222222221 15.5 17.77777777777778 13.625 21.333333333333332 6.125 24.888888888888886 4.25 28.444444444444443 0.5 32 6.125" stroke="#169c81" stroke-width="1" stroke-linecap="square"></polyline></svg>
                                            </td>
                                            <td><?=$r['organization_name']?></td>
                                            <td class="text-navy">  <?=$r['member_count']?></td>
                                        </tr>
                                    </tr>
                                 <?php endforeach;?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Amount of Each Member</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">选项1</a>
                                    </li>
                                    <li><a href="#">选项2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
    
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Member ID</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Statement Desc</th>
                                        <th>Room Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach($memberAmount as $r):?>
                                    <tr>
                                         <tr>
                                            <td><?=$r['member_id']?></td>
                                            <td><?=$r['email']?></td>
                                            <td><?=$r['phone']?></td>
                                            <td><?=$r['statement_desc']?></td>
                                            <td class="text-navy">  <?=$r['amount']?></td>
                                        </tr>
                                    </tr>
                                 <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="col-sm-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Organization Total Amount</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="table_basic.html#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="table_basic.html#">选项1</a>
                                    </li>
                                    <li><a href="table_basic.html#">选项2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
    
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Organization ID</th>
                                        <th>数据</th>
                                        <th>Organization Name</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($organizationAmount as $r):?>
                                    <tr>
                                         <tr>
                                            <td><?=$r['organization_id']?></td>
                                            <td><span class="line" style="display: none;">5,3,2,-1,-3,-2,2,3,5,2</span><svg class="peity" height="16" width="32"><polygon fill="#1ab394" points="0 9.375 0 0.5 3.5555555555555554 4.25 7.111111111111111 6.125 10.666666666666666 11.75 14.222222222222221 15.5 17.77777777777778 13.625 21.333333333333332 6.125 24.888888888888886 4.25 28.444444444444443 0.5 32 6.125 32 9.375"></polygon><polyline fill="transparent" points="0 0.5 3.5555555555555554 4.25 7.111111111111111 6.125 10.666666666666666 11.75 14.222222222222221 15.5 17.77777777777778 13.625 21.333333333333332 6.125 24.888888888888886 4.25 28.444444444444443 0.5 32 6.125" stroke="#169c81" stroke-width="1" stroke-linecap="square"></polyline></svg>
                                            </td>
                                            <td><?=$r['organization_name']?></td>
                                            <td class="text-navy">  <?=$r['amount']?></td>
                                        </tr>
                                    </tr>
                                 <?php endforeach;?>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
    <?=Html::jsFile('@web/js/jquery.min.js?v=2.1.4')?>
    <?=Html::jsFile('@web/js/bootstrap.min.js?v=3.3.6')?>
    <?=Html::jsFile('@web/js/plugins/echarts/echarts-all.js')?>
    <?=Html::jsFile('@web/js/content.min.js?v=1.0.0')?>
    <?=Html::jsFile('@web/js/demo/echarts-demo.min.js')?>
    <?=Html::jsFile('@web/js/plugins/Highcharts/4.1.7/js/highcharts.js')?>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

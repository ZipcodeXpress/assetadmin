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
                        <li id="tab_import" class=""><a data-toggle="tab" href="#tab-2" aria-expanded="true">Import Member</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                               asdadadsd
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="form-group">
                                    <h3>Please use this template to import. <a href="http:\\www.zipcodexpress.com\wp-content\member-template.csv">Download</a></h3>
                                </div>
                               
                               
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

<?php

/* @var $this \yii\web\View */
/* @var $content string */

// use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

// AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>Zipcodexpress Asset Management System</title>
    <meta name="keywords" content="Zipcodexpress Management System">
    <meta name="description" content="Zipcodexpress Management System">
    <!--[if lt IE 9]>
    <!--<meta http-equiv="refresh" content="0;ie.html" />-->
    <!--endif]-->
    <link rel="shortcut icon" href="favicon.ico">
    <link href="css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/xadmin.css">
        <!-- <link rel="stylesheet" href="./css/theme5.css"> -->
        <script src="lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="js/xadmin.js"></script>
    <script src="js/plugins/iCheck/icheck.min.js"></script>

    <?php $this->head() ?>
</head>
<!--style>
body
{
	font-family: CiscoSans,Arial,sans-serif !important;
    font-size: 10px;
	line-height:1;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: 1px solid #e7eaec;
    line-height: 1;
    padding: 4px;
    vertical-align: middle;
}
.form-control, .single-line {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 3px 6px;
    -webkit-transition: border-color .15s ease-in-out 0s,box-shadow .15s ease-in-out 0s;
    transition: border-color .15s ease-in-out 0s,box-shadow .15s ease-in-out 0s;
    width: 100%;
    font-size: 12px;
}
</style-->
<body class="index">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

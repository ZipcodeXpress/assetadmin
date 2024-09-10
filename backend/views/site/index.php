<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'ZipcodeXpress Asset Management System';
?>
<!-- 顶部开始 -->
<div class="container">
    <div class="logo">
        <a href="#">ZipcodeXpress</a> </div> <div class="left_open">
            <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>

 
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">admin</a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.open('Profile','<?= Url::toRoute(['user/update', 'id' => Yii::$app->user->identity->getId(), 'act' => 'updateProfile']) ?>',800,600)">
                            <cite>Admin Profile</cite></a></dd>
               
                <dd>
                    <a href="<?=Url::toRoute('site/logout')?>">Exit</a></dd>
            </dl>
        </li>
       
    </ul>
</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>

                <span><img alt="image" class="img-circle" src="<?= $user_head_img ?>" width="64" height="64" /></span>
                <a href="#">

                    <span class="block m-t-xs" style="line-height:1.4;"><strong class="font-bold"><?= Yii::$app->user->identity->username ?></strong></span>
                    <span class="text-muted text-xs block" style="line-height:1;"><?= $user_info ?><b class="caret"></b></span>

                </a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.open('Admin Profile', '<?= Url::toRoute(['user/update', 'id' => Yii::$app->user->identity->getId(), 'act' => 'updateProfile']) ?>',800,600)">
                            <cite>Admin Profile</cite>
                        </a>
                    </li>

                    <li>
                    <a href="<?=Url::toRoute('site/logout')?>">Exit</a>
                    </li>
                </ul>

                <div class="logo-element">Zippora
                </div>
            </li>

            <?php foreach ($menu as $v1) : ?>
                <?php $data = json_decode($v1['data'], true); ?>
                <li>
                    <!--一级菜单-->
                    <a href="#">
                       
                    <i class="iconfont left-nav-li" ><?= $v1['data'] ?></i>
                        
                         <cite><?= $v1['name'] ?></cite>
                        <span class="fa arrow"></span>
                    </a>
                    <?php if (array_key_exists('_child', $v1)) : ?>
                        <ul class="sub-menu">
                            <?php foreach ($v1['_child'] as $v2) : ?>
                                <?php $data2 = json_decode($v2['data'], true); ?>
                                <?php if (array_key_exists('_child', $v2)) : ?>
                                    <li>
                                        <!--二级菜单-->
                                        <a href="#">
                                            <?php if ($data2['icon']) : ?><i class="<?= $data2['icon'] ?>"></i><?php endif; ?><?= $v2['name'] ?>
                                            <span class="fa arrow"></span>
                                        </a>
                                        <?php if (!empty($v2['_child'])) : ?>
                                            <ul class="sub-menu">
                                                <?php foreach ($v2['_child'] as $v3) : ?>
                                                    <li>
                                                        <!--三级菜单-->
                                                        <a onclick="xadmin.add_tab('<?= $v3['name'] ?>', '<?= Url::toRoute($v3['route']) ?>')">
                                                            <cite><?= $v3['name'] ?></cite></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <!--二级菜单-->
                                        <a onclick="xadmin.add_tab('<?= $v2['name'] ?>', '<?= Url::toRoute($v2['route']) ?>')">
                                            <cite><?= $v2['name'] ?></cite></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
            <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
                <ul class="layui-tab-title">
                    <li class="home">
                        <i class="layui-icon">&#xe68e;</i>Home</li></ul>
                <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                    <dl>
                        
                        <dd data-type="other">Close Others</dd>
                        <dd data-type="all">Close all</dd></dl>
                </div>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src=<?= Url::toRoute('report/zippora')?> frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                    </div>
                </div>
                <div id="tab_show"></div>
            </div>
        </div>
        <div class="page-content-bg"></div>
        <style id="theme_style"></style>

<!-- 右侧主体结束 -->

        
<!-- 中部结束 -->
<script src="js/jquery.min.js?v=2.1.4"></script>
    <script src="js/bootstrap.min.js?v=3.3.6"></script>
    <script src="js/content.min.js?v=1.0.0"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/layer/layer.min.js"></script>
    <script src="js/plugins/layer/layDate-v5.0.85/laydate/laydate.js"></script>
    <script src="js/hplus.min.js?v=4.1.0"></script>
    <script type="text/javascript" src="js/contabs.min.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

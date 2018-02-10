<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>班级列表</title>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/manager_class.css">
</head>
<body>
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">班级列表</span>
    <!--右侧按钮-->
    <span class="header-btn">
        <a href="<?php echo U('Home/MyClass/addClass');?>" style="font-weight: normal;font-size: 12px">
            添加班级
        </a>
    </span>

</div>

<div class="page">
    <div class="class-list-box">

    <!--班级列表-->
    <?php if(is_array($classes)): $i = 0; $__LIST__ = $classes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$class): $mod = ($i % 2 );++$i;?><div  class="class-list clearfix">
            <a href="<?php echo U('Home/MyClass/classDetail',array('class_id' => $class['class_id']));?>" class="img-box">
                <div class="mask"></div>
                <img src="<?php echo imageDomain($class['image']);?>" alt="">
                <p><?php echo ($class['class_name']); ?></p>
            </a>
            <div class="deal-class">
                <div class="left-deal">
                    <a href="<?php echo U('Home/MyClass/editClass',array('class_id' => $class['class_id']));?>">编辑</a>
                </div>
                <div class="right-deal">
                    <a href="<?php echo U('Home/MyClass/delClass',array('class_id' => $class['class_id']));?>"><i class="txh icon-shanchu1"></i></a>
                </div>
            </div>

        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>

</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>

</html>
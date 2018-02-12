<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/my_works.css">
    <title>今日作业</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">今日作业</span>
    <!--右侧按钮-->
    <span class="header-btn">

    </span>

</div>
<div class="page">
    <div class="my-works-box" style="height: 50%;">
        <div class="my-work-title">
            <i class="txh icon-xiaobenkechengtongji"></i>
            普通课程
        </div>
        <div class="class-list-box">
            <?php if(is_array($classes)): foreach($classes as $key=>$item): ?><a href="<?php echo U('student/tasklist', array('classid'=>$item['class_id']));?>" class="class-list clearfix">
                    <img src="<?php echo imageDomain($item['class_img'], '/mobile/images/activity/class2.png');?>" alt="">
                    <p><?php echo ($item["class_name"]); ?></p>
                </a><?php endforeach; endif; ?>
        </div>
    </div>

    <div class="my-works-box" style="height: 50%;">
        <div class="my-work-title">
            <i class="txh icon-xiaobenkechengtongji"></i>
            我的活动
        </div>
        <div class="class-list-box">
            <?php if(is_array($Curriculum)): foreach($Curriculum as $key=>$item): ?><a href="<?php echo U('student/tasklist', array('grade_id'=>$item['grade_id']));?>" class="class-list clearfix">
                    <img src="<?php echo imageDomain($item['grade_img'], '/mobile/images/activity/class2.png');?>" alt="">
                    <p><?php echo ($item["grade_name"]); ?></p>
                </a><?php endforeach; endif; ?>
        </div>
    </div>

</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>

</html>
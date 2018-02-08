<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/css/swiper.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/css/dropload.css">
    <link rel="stylesheet" href="/mobile/style/student_personal.css">
    <title>个人中心</title>
    <script src="/mobile/js/zepto.min.js"></script>
    <script src="/mobile/js/weui.min.js"></script>
    <script src="/mobile/js/jweui.min.js"></script>
    <script src="/mobile/js/swiper.min.js"></script>
    <script type="text/javascript" src="/mobile/js/dropload.min.js"></script>
</head>
<body>

    <div class="header">
        <div class="header-img">
            <div class="teacher-header">
                <a href="<?php echo U('user/personal_infor');?>">
                    <img src="<?php echo imageDomain($userInfo['head_img']);?>"  style="border-radius: 50%;" alt="">
                </a>
            </div>
            <p><?php echo ($userInfo["nickname"]); ?></p>
        </div>
    </div>
    <div class="page">
        <div class="weui-tabbar page-tabber">
            <a href="<?php echo U('activity/index');?>" class="weui-tabbar__item">
                <img src="/mobile/images/person/icon1.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我的活动</p>
            </a>
            <a href="<?php echo U('grade/index');?>" class="weui-tabbar__item">
                <img src="/mobile/images/person/icon1.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我的班级</p>
            </a>
            <a href="<?php echo U('grade/index', array('type'=>1));?>" class="weui-tabbar__item">
                <img style="width: 24px" src="/mobile/images/person/icon3.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我的课程</p>
            </a>
        </div>
        <div class="page-placeholder"></div>
        <div class="page-list">
<!--             <div class="weui-cells">

                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__bd">
                        <p>我的讲解</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>

                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__bd">
                        <p>我的收藏</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>

            </div> -->
        </div>
    </div>


<div class="footer">
    <div class="weui-tabbar footer-tabber">
        <a href="/" class="weui-tabbar__item">
            <img src="/mobile/images/footer-icon1.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">首页</p>
        </a>
        <a href="<?php echo U('forum/index');?>" class="weui-tabbar__item">
                    <span style="display: inline-block;position: relative;">
                        <img src="/mobile/images/footer-icon2.png" alt="" class="weui-tabbar__icon">
                    </span>
            <p class="weui-tabbar__label">微论坛</p>
        </a>
        <a href="<?php echo U('user/personal');?>" class="weui-tabbar__item">
            <img src="/mobile/images/footer-icn3.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">我的</p>
        </a>
    </div>
</div>
</body>
<script type="text/javascript">
    $(function(){
        $(document.body).dropload({
            scrollArea : window,
            loadUpFn : function(me){
                document.location.reload();
                me.resetload();
            }
        });
    });
</script>
</html>
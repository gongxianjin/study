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
    
<link rel="stylesheet" href="/mobile/style/index.css">
<link rel="stylesheet" href="/mobile/style/teacherIndex.css">

    <title>首页</title>
    <script src="/mobile/js/zepto.min.js"></script>
    <script src="/mobile/js/weui.min.js"></script>
    <script src="/mobile/js/jweui.min.js"></script>
    <script src="/mobile/js/swiper.min.js"></script>
    <script type="text/javascript" src="/mobile/js/dropload.min.js"></script>
</head>
<body>

    <div class="header">
        <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <a href="#"><img src="/mobile/images/logo.png" alt=""></a>
        </span>
        <!--中间文字-->
        <span class="header-text">童学惠</span>
        <!--右侧按钮-->
        <span class="header-btn">
        <?php if(session('?login_info')): ?><a href="<?php echo U('user/personal');?>"><i class="txh icon-geren-80"></i></a>
        <?php else: ?>
            <a href="<?php echo U('login/index');?>"><i class="txh icon-geren-80"></i></a><?php endif; ?>
    </span>
    </div>

    <div class="page">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/mobile/images/slide1.png" alt=""></div>
                <div class="swiper-slide"><img src="/mobile/images/slide2.png" alt=""></div>
                <div class="swiper-slide"><img src="/mobile/images/slide1.png" alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <!--根据不同身份切换不同模板-->
        <?php if($user_type == 2): ?><!--管理员-->
            <!--管理员-->
<div class="activity-container">
    <div class="weui-flex">
        <a href="teacher_activity.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy1.png" alt="">
                <p>活动管理</p>
            </div>
        </a>
        <a href="maneger_class.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy2.png" alt="">
                <p>班级管理</p>
            </div>
        </a>
        <a href="integral_manager.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy3.png" alt="">
                <p>积分管理</p>
            </div>
        </a>
        <a href="library.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy4.png" alt="">
                <p>图书馆管理</p>
            </div>
        </a>
    </div>
</div>
<div class="absent-day">
    <div class="absent-container">
        <div class="left-absent_img">
            <img src="/mobile/images/absent.png" alt="">
        </div>
        <div class="center-calender">
            <a href="person_manager.html">
                <i class="txh icon-xingming"></i>
                用户管理
            </a>
            <a id="tongji" href="#" style="margin-left: 10px">
                <i class="txh icon-xiaobenkechengtongji"></i>
                数据统计
            </a>
        </div>
        <div class="right-days">

        </div>
    </div>
</div>
        <?php elseif($user_type == 1): ?>
            <!-- 教师 -->
            <!--教师-->
<div class="activity-container">
    <div class="weui-flex">
        <a href="teacher_activity.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy1.png" alt="">
                <p>我的活动</p>
            </div>
        </a>
        <a href="maneger_class.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy2.png" alt="">
                <p>我的班级</p>
            </div>
        </a>
        <a href="student_manager.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy3.png" alt="">
                <p>学生管理</p>
            </div>
        </a>
        <a href="library.html" class="weui-flex__item">
            <div class="placeholders">
                <img src="/mobile/images/buy4.png" alt="">
                <p>图书馆管理</p>
            </div>
        </a>
    </div>
</div>
<div class="absent-day">
    <div class="absent-container">
        <div class="left-absent_img">
            <img src="/mobile/images/absent.png" alt="">
        </div>
        <div class="center-calender">
            <a href="homemade_book.html">
                <i class="txh icon-jia"></i>
                创建作业
            </a>
        </div>
        <div class="right-days">

        </div>
    </div>
</div>
        <?php else: ?>
            <!-- 学生 -->
            <!--学生模板-->
<div class="activity-container">
    <div class="weui-flex">
        <a class="weui-flex__item" href="<?php echo U('activity/index');?>">
            <div  class="placeholder">
                <img src="/mobile/images/buy1.png" alt="">
                <p>课程活动</p>
            </div>
        </a>
        <a class="weui-flex__item">
            <div  class="placeholder">
                <img src="/mobile/images/buy2.png" alt="">
                <p>今日作业</p>
            </div>
        </a>
        <a class="weui-flex__item" href="<?php echo U('shop/index');?>">
            <div  class="placeholder">
                <img src="/mobile/images/buy3.png" alt="">
                <p>积分商城</p>
            </div>
        </a>
        <a class="weui-flex__item" href="<?php echo U('library/index');?>">
            <div  class="placeholder">
                <img src="/mobile/images/buy4.png" alt="">
                <p>图书馆</p>
            </div>
        </a>
    </div>
</div>
<div class="absent-day">
    <div class="absent-container">
        <div class="left-absent_img">
            <img src="/mobile/images/absent.png" alt="">
        </div>
        <div class="center-calender">
            <i class="txh icon-rili"></i>
            <span>缺课天数</span>
        </div>
        <div class="right-days">
            <span>20天</span>
        </div>
    </div>
</div><?php endif; ?>

        <div class="hots">
            <div class="hot-header">
                <i class="txh icon-remen"></i>
                <span>热门活动</span>
            </div>
            <div class="hot-content">
                <div class="weui-flex">
                    <?php if(is_array($hotActivity)): foreach($hotActivity as $key=>$item): ?><a class="weui-flex__item" href="<?php echo U('activity/details', array('activity_id'=>$item['id']));?>">
                            <div  class="placeholder" style="margin-right: 10px">
                                <img src="<?php echo imageDomain($item['cover_img'], '/mobile/images/slide1.png');?>" alt="">
                            </div>
                        </a><?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        var swiper = new Swiper('.swiper-container', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows : true,
            },
            pagination: {
                el: '.swiper-pagination',
            },
        });
    </script>


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
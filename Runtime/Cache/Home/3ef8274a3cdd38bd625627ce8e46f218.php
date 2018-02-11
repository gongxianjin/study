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
                    <?php if($userInfo['head_img']): ?><img src="<?php echo imageDomain($userInfo['head_img']);?>"  style="border-radius: 50%;" alt="">
                        <?php else: ?>
                        <img src="/mobile/images/person/header_teacher.png"  style="border-radius: 50%;" alt=""><?php endif; ?>
                </a>
            </div>
            <p><?php echo ($userInfo["nickname"]); ?></p>
        </div>
    </div>

    <div class="page">
        <div class="weui-tabbar page-tabber">
            <a href="javascript:;" class="weui-tabbar__item">
                <img style="width: 24px" src="/mobile/images/person/icon3.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我的课程</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item">
                    <span style="display: inline-block;position: relative;">
                        <img src="/mobile/images/person/icon1.png" alt="" class="weui-tabbar__icon">
                    </span>
                <p class="weui-tabbar__label">我的班级</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item">
                <img style="width: 18px;height: 18px" src="/mobile/images/person/icon4.png" alt="" class="weui-tabbar__icon">
                <p class="weui-tabbar__label">我的作品</p>
            </a>
        </div>
        <div class="page-placeholder"></div>
        <div class="page-list">
            <div class="weui-cells">
                <a class="weui-cell weui-cell_access" href="<?php echo U('user/integral');?>">
                    <div class="weui-cell__bd">
                        <p>我的积分</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__bd">
                        <p>缺读记录</p>
                    </div>
                    <div class="weui-cell__ft">缺读天数 0 天</div>
                </a>
                <a id="showIOSDialog1" class="weui-cell weui-cell_access" href="javascript:;">
                    <div class="weui-cell__bd">
                        <p>生成专属二维码</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
<!--                 <a class="weui-cell weui-cell_access" href="<?php echo U('user/deposit_cash');?>" >
                    <div class="weui-cell__bd">
                        <p>申请退还保证金</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a> -->
                <a id="show_deposit" class="weui-cell weui-cell_access">
                    <div class="weui-cell__bd">
                        <p>申请退还保证金</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access" href="<?php echo U('login/loginout');?>">
                    <div class="weui-cell__hd">
                        <p>退出</p>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <div class="js_dialog" id="iosdeposit" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd">选择活动</div>
            <div class="weui-dialog__bd">
                <div class="deposit_box">
                    <?php if(is_array($activity)): $i = 0; $__LIST__ = $activity;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><a href="<?php echo U('user/deposit_cash',array('g_id' => $a['g_id']));?>"><?php echo ($a["activity_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>

        </div>
    </div>
    <div class="js_dialog" id="iosDialog1" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <!--
                    <div class="weui-dialog__hd"><strong class="weui-dialog__title">我的专属二维码</strong></div>
            -->
            <div class="weui-dialog__bd">
                <div class="title-me">
                    <div class="title-me-left">
                        <img src="/mobile/images/person/header_teacher.png" alt="">
                    </div>
                    <div class="title-me-right">
                        <p>欧阳果果</p>
                        <span style="margin-right: 10px">四川</span><span>成都</span>
                    </div>
                </div>
                <div class="hd-body">
                    <div class="hd-img">
                        <img src="/mobile/images/person/erweima.jpg" alt="">
                    </div>

                </div>
            </div>
            <div class="weui-dialog__ft">
                <p>用手机扫描二维码，加我好友</p>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            var $iosDialog1 = $('#iosDialog1');
            var $depositBox =$("#iosdeposit");
            $('#showIOSDialog1').on('click', function(){
                $iosDialog1.fadeIn(200);
            });

            $('#show_deposit').on('click', function(){
                $depositBox.fadeIn(200);
            });
            $(".weui-mask").click(function(){
                $iosDialog1.fadeOut(200);
                $depositBox.fadeOut(200);
            });
        })
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
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/classPage.css">
    <title>学生班级页面</title>
    <script type="text/javascript" src="/mobile/layui/layui.js"></script>
    <script type="text/javascript" src="/mobile/layer/layer.js"></script>
    <script src="/mobile/js/zepto.min.js"></script>
    <script src="/mobile/js/weui.min.js"></script>
    <script src="/mobile/js/jweui.min.js"></script>
</head>
<body>

<div class="dropload-up"></div>
<div class="header">
    <div class="header-top">
        <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
        <!--中间文字-->
        <span class="header-text">学生班级页面</span>
        <!--右侧按钮-->
         <span class="header-btn">
                <a href="#"><i class="txh icon-share"></i></a>
        </span>
    </div>
    <div class="header-down">
        <div class="announcement">
            <div class="announcement-left">
                <img src="/mobile/images/classPage/left1.png" alt="">
            </div>
            <div class="announcement-right">
                某某同学该交学费了哈，速度点...
            </div>
        </div>
    </div>
</div>
<div class="page">
    <div class="lesson-header">
        <h4><?php echo ($class["class_name"]); ?>课程</h4>
        <div class="lesson-box">
            <div class="lesson-left"><?php echo ($class["count"]); ?>人已参加</div>
            <div class="lesson-right"><?php echo ($taskcounts); ?>次交作业</div>
        </div>
        <div class="lesson-down">
            <div class="head-teacher">班主任:<span><?php echo ($teacher["username"]); ?></span></div>
            <div class="join-weixin">
                <a href="#">加微信<i class="txh icon-weixin1"></i></a>
            </div>
        </div>
    </div>
    <div class="lesson-content">
        <div class="lesson-content-title">
            <div class="content-title-left">
                <i class="txh icon-zuoye"></i>已交作业5天
            </div>
            <div class="content-title-right">
                目标数:<span>26天</span>
            </div>
        </div>
        <div class="weui-progress">
            <div class="weui-progress__bar">
                <div class="weui-progress__inner-bar js_progress" style="width: 30%;"></div>
            </div>
        </div>
        <div class="lesson-tab">
            <div class="lesson-title">
                <div class="lesson-item <?php if( 1 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>一</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w'))-1)*24*3600))?></span>
                </div>
                <div class="lesson-item <?php if( 2 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>二</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w'))-2)*24*3600))?></span>
                </div>
                <div class="lesson-item <?php if( 3 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>三</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w'))-3)*24*3600))?></span>
                </div>
                <div class="lesson-item <?php if( 4 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>四</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w'))-4)*24*3600))?></span>
                </div>
                <div class="lesson-item <?php if( 5 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>五</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w'))-5)*24*3600))?></span>
                </div>
                <div class="lesson-item <?php if( 6 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>六</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w'))-6)*24*3600))?></span>
                </div>
                <div class="lesson-item <?php if( 0 == date('w',(time()))):?> lesson-item-active <?php endif;?>">
                    <p>日</p>
                    <span><?php echo date('d',(time()-((date('w')==0?7:date('w')))*24*3600))?></span>
                </div>
            </div>
            <div class="pass-content">
                <?php if(($classtask != '') AND ($classtask['setup'] == 0)): ?><a href="<?php echo U('student/index', array('taskid'=>$classtask['id']));?>"><i class="txh icon-wancheng"></i>
                        去做作业
                    </a>
                <?php elseif(($classtask == '') OR ($classtask['setup'] == 1)): ?>
                    <a href="#"><i class="txh icon-wancheng"></i>
                        今日已交作业！
                    </a><?php endif; ?>
                <p><?php echo date('H:i:s',$classtask['time'])?></p>
            </div>
        </div>
        <div class="lesson-footer">
            <a href="integral.html" style="color: #21dcfd"><i class="txh icon-paihangbang"></i>我的积分排行榜</a>
        </div>
    </div>

</div>
</body>

<script>
    $(function(){
        $(".lesson-title").on("click",".lesson-item",function(){
            if(!$(this).hasClass("lesson-item-active")){
                $(this).addClass("lesson-item-active").siblings().removeClass("lesson-item-active");
                $($(".pass-content")[$(this).index()]).css("display","block").siblings().css("display","none");
                $(".lesson-title").css("display","flex")
            }
        })
    })
</script>
</html>
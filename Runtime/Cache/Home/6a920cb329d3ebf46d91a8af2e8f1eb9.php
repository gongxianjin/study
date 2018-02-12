<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/work_detail.css">
    <script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/city-picker.data.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script type="text/javascript" src="/mobile/js/dropload.min.js"></script>
<script>
     function ajaxReturnMsg(param, reload)
     {
         if((typeof param.code) == 'undefined')
         {
             weui.alert('网络异常, 请稍后重试');
             return false;
         }

         if((typeof param.data['redirect_url']) != 'undefined')
         {
             window.location.href = param.data['redirect_url'];
             return false;
         }

         weui.alert(param.message, function()
         {
             if(reload && param.code == 0){
                 window.location.reload();
             }
         });
         return param.data;
     }
     function getCode()
     {
         var sendCode = $('#send_code');
         if(sendCode.html() != '发送验证码'){
             return;
         }
         var phone = $('input[name="phone"]').val();
         if( ! /^1[34578]\d{9}$/.test(phone) ){
             weui.alert('手机号码格式不正确');
             return;
         }
         $.getJSON("<?php echo U('login/getCode');?>", {phone: phone}, function(param)
         {
             if((typeof param.code) == undefined)
             {
                 weui.alert('网络异常, 请稍后重试');
                 return ;
             }
             var m = 60;
             var clear = setInterval(function(){
                 m -= 1;
                 sendCode.html( m + "秒");
                 if(m < 0)
                 {
                     sendCode.html('发送验证码');
                     clearInterval(clear);
                 }
             }, 1000);
             weui.alert(param.message);
         });
     }
     function checkPhone(phone)
     {
         if( ! /^1[34578]\d{9}$/.test(phone) ){
             weui.alert('手机号码格式不正确');
             return false;
         }
         return true;
     }

     function province()
     {
         var province = [];
         for(var code_id in ChineseDistricts[86])
         {
             var cityChildren = [];
             for( var city_id in ChineseDistricts[code_id])
             {
                 var countyChildren = [];
                 for( var county_id in ChineseDistricts[city_id])
                 {
                     countyChildren.push({
                         label: ChineseDistricts[city_id][county_id],
                         value: ChineseDistricts[city_id][county_id]
                     });
                 }
                 cityChildren.push({
                     label: ChineseDistricts[code_id][city_id],
                     value: ChineseDistricts[code_id][city_id],
                     children: countyChildren
                 });
             }
             province.push({
                 label: ChineseDistricts[86][code_id],
                 value: ChineseDistricts[86][code_id],
                 children: cityChildren
             });
         }
         return province;
     }

     function checkCode(code)
     {
         if( ! /^\d{6}$/.test(code) ){
             weui.alert('手机验证码不正确');
             return false;
         }
         return true;
     }

     function checkPassword(password)
     {
         if( ! /^[\w\~\!@#$%\^\&\*\(\)_\+|\\=-`\/\.\,\?\>\<';":]{6,20}$/.test(password) ){
             weui.alert('密码格式不正确，密码为6到20的字符');
             return false;
         }
         return true;
     }
</script>
    <title>作业详情</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
        <i class="txh icon-xiangzuo"></i>
    </span>
    <!--中间文字-->
    <span class="header-text">作业详情</span>
    <!--右侧按钮-->
    <span class="header-btn">
        <a href="#"><i class="txh icon-share"></i></a>
    </span>

</div>
<div class="work-content">
    <div class="play-function">
        <a href="#">
            听原音
            <i class="txh icon-bofang"></i>
        </a>
        <a href="#">
            听录音
            <i class="txh icon-zanting"></i>
        </a>
    </div>
    <div class="img-box">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
    </div>
    <div class="pagetion"><span>11</span>/<span>20</span></div>
</div>
<div class="page">
    <div class="infor-box">
        <div class="left-infor-box">
            <div class="header-img-box">
                <div class="img-box">
                    <img src="/mobile/images/header_img.png" alt="">
                </div>
                <p>李鑫鑫</p>
            </div>
            <div class="all-flowers">
                <label>作品红花:</label>
                <span class="flowers-num">70</span>
                <i class="txh icon-shuye"></i>
            </div>
        </div>
        <div class="right-infor-box">
            <a href="#" class="text-conment">
                文字点评
                <i class="txh icon-pinglun1"></i>
            </a>
            <a href="#" class="text-conment">
                语音点评
                <i class="txh icon-msnui-mic"></i>
            </a>
            <a href="#" class="text-conment">
                收听点评
                <i class="txh icon-wifi"></i>
            </a>
            <a href="#" class="text-conment">
                点赞送花
                <i class="txh icon-dianzan"></i>
            </a>
        </div>
    </div>

</div>
<div class="js_dialog" id="iosDialog1" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <!--
                <div class="weui-dialog__hd"><strong class="weui-dialog__title">加入班级</strong></div>
        -->
        <div class="weui-dialog__bd">
            <div class="weui-cell">
                <div class="weui-cell__bd" style="border:1px solid #e8e8e8;line-height: 30px;">
                    <textarea rows="3" class="weui-textarea comment-text"><?php echo ($work['comment_text']); ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>
<!--翻页-->
<script>
    var ele = document.getElementsByClassName("img-box")[0];
    var beginX, beginY, endX, endY, swipeLeft, swipeRight;
    ele.addEventListener('touchstart', function (event) {
        event.stopPropagation();
        event.preventDefault();
        beginX = event.targetTouches[0].screenX;
        beginY = event.targetTouches[0].screenY;
        swipeLeft = false, swipeRight = false;
    });

    ele.addEventListener('touchmove', function (event) {
        event.stopPropagation();
        event.preventDefault();
        endX = event.targetTouches[0].screenX;
        endY = event.targetTouches[0].screenY;
        // 左右滑动
        if (Math.abs(endX - beginX) - Math.abs(endY - beginY) > 0) {
            /*向右滑动*/
            if (endX - beginX > 0) {
                swipeRight = true;
                swipeLeft = false;
                alert(11)
            }
            /*向左滑动*/
            else {
                swipeLeft = true;
                swipeRight = false;
                alert(22)
            }
        }
    });
    ele.addEventListener('touchend', function (event) {
        event.stopPropagation();
        event.preventDefault();

        if (Math.abs(endX - beginX) - Math.abs(endY - beginY) > 0) {
            event.stopPropagation();
            event.preventDefault();if (swipeRight) {
                swipeRight = !swipeRight;
                /*向右滑动*/
                alert(11)
            }
            if(swipeLeft) {
                swipeLeft = !swipeLeft;
                /*向左滑动*/
                alert(2)
            }
        }
    });
</script>
<!--弹出框-->
<script>
    $(".text-conment ").on("click",function () {
        $("#iosDialog1").css("display","block");
        $(".weui-mask").css({opacity:"1",visibility: "visible"});
        $(".weui-dialog").css({opacity:"1",visibility: "visible"});
    });
    $(".weui-mask").on("click",function () {
        $("#iosDialog1").css("display","none");
        $(".weui-mask").css({opacity:"0",visibility: "hidden"});
        $(".weui-dialog").css({opacity:"0",visibility: "hidden"});
    });
    $(".close_btn").on("click",function () {
        $("#iosDialog1").css("display","none");
        $(".weui-mask").css({opacity:"0",visibility: "hidden"});
        $(".weui-dialog").css({opacity:"0",visibility: "hidden"});
    });


    $('.add-text-comment-btn').click(function(){
        var id = "<?php echo I('get.id');?>}";
        var task_id = "<?php echo I('get.task_id');?>";
        $.post("<?php echo U('MyClass/addTextComment');?>",{id:id,task_id:task_id,comment:$('.comment-text').val()},function(res){
            ajaxReturnMsg(res);
        })
    });
</script>
</html>
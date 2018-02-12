<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/layui/css/layui.css">
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/css/dropload.css">
    <link rel="stylesheet" href="/mobile/css/style.css">
    
    <style type="text/css">
        .page{
            width: 100%; height: 100%;
        }
        .page img{
            width: 100%; height: 100%;
            position: absolute;
        }
        #myCanvas{
            border-radius: 50%; width: 35px; height: 35px; position: absolute; margin-left: 3px;
        }
    </style>

    <title><?php echo ($bookInfo["name"]); ?></title>
    <script type="text/javascript" src="/mobile/layui/layui.js"></script>
    <script type="text/javascript" src="/mobile/layer/layer.js"></script>
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
</head>
<body>

<div class="dropload-up"></div>
<div class="header">
        <span class="header-back" onclick="window.history.back();">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <span class="header-text"><?php echo ($bookInfo["name"]); ?></span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
        
    </span>
</div>


    <div class="page">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
        <img src="/mobile/images/book/content_bg.jpg" alt="">
    </div>


    <div class="weui-tabbar">

        <a href="javascript:;" class="weui-tabbar__item">
            <img src="/mobile/images/voice.png" class="weui-tabbar__icon" style="margin-top: 14px;">
            <p class="weui-tabbar__label">听原音</p>
        </a>

        <a href="javascript:;"  class="weui-tabbar__item">
            <canvas id="myCanvas"></canvas>
            <span style="display: inline-block;position: relative;">
                <img src="/mobile/images/luyin.png" class="weui-tabbar__icon" style="width: 40px;height: 34px">
            </span>
            <p class="weui-tabbar__label">录制</p>
        </a>

        <a href="javascript:;" class="weui-tabbar__item">
            <img src="/mobile/images/shiting.png" class="weui-tabbar__icon" style="margin-top: 14px;">
            <p class="weui-tabbar__label">试听</p>
        </a>

    </div>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script>
        wx.startRecord();
//
//        wx.config({
//            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//            appId: '', // 必填，公众号的唯一标识
//            timestamp: '', // 必填，生成签名的时间戳
//            nonceStr: '', // 必填，生成签名的随机串
//            signature: '',// 必填，签名，见附录1
//            jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
//        });
//        wx.startRecord();
//
//        wx.stopRecord({
//            success: function (res) {
//                var localId = res.localId;
//            }
//        });
//
//        wx.onVoiceRecordEnd({
//            complete: function (res) {
//                var localId = res.localId;
//            }
//        });
    </script>

</body>

</html>
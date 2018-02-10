<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/find_password.css">
    <title>找回登录密码</title>
</head>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<body>
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">找回登录密码</span>
    <!--右侧按钮-->
</div>
<div class="page">
    <form action="#">
        <div class="login-box">
            <div class="login-list">
                <i class="txh icon-shouji"></i>
                <input type="text" name="phone" placeholder="请输入您的手机号码">
            </div>
            <div class="login-list list-yanzheng">
                <i style="font-size: 18px;margin-left: 5px;margin-top: 5px" class="txh icon-shiliangzhinengduixiang"></i>
                <input type="text" name="code" placeholder="输入短信验证码">
                <a href="#" id="send_code" onclick="getCode();" >发送验证码</a>
            </div>
            <div class="login-list">
                <i class="txh icon-suo" style="margin-left: 3px;font-size: 20px;margin-top: 4px"></i>
                <input type="password" name="password" placeholder="请输入您的新密码">
            </div>
            <div class="login-list">
                <i class="txh icon-suo" style="margin-left: 3px;font-size: 20px;margin-top: 4px"></i>
                <input type="password" name="_password" placeholder="请再次确认密码">
            </div>
            <div class="login-submit">
                <a href="#" onclick="ck.findPassword();" >确认修改</a>
            </div>
        </div>
    </form>

</div>
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
<script>
    (function(_){
        _.findPassword = function()
        {
            var phone = $('input[name="phone"]').val();
            if( ! checkPhone(phone) ){
                return;
            }
            var code = $('input[name="code"]').val();
            if( ! checkCode(code) ){
                return;
            }
            var password = $('input[name="password"]').val();
            var _password = $('input[name="_password"]').val();
            if( ! checkPassword(password) || ! checkPassword(_password) ){
                return;
            }
            $.post("<?php echo U('login/findPassword');?>", {phone: phone, code: code, password: password}, function(param){
                ajaxReturnMsg($.parseJSON(param));
            }, "JSON");
        }
    })(ck={});
</script>
</body>
</html>
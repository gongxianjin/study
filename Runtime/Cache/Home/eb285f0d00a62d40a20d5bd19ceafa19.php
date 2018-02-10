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
    
    <link rel="stylesheet" href="/mobile/style/teacher_activity.css">

    <title>我的活动</title>
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
    <span class="header-text">我的活动</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
         <a href="<?php echo U('activity/create');?>">创建活动</a> 
    </span>
</div>

    <div class="page">
        <div class="class-list-box">
            <?php if(is_array($showData)): foreach($showData as $key=>$item): ?><div class="activity-list">
                    <div class="img-box">
                        <a href="<?php echo U('activity/details', array('activity_id'=>$item['id']));?>">
                            <img src="<?php echo imageDomain($item['cover_img'], '/mobile/images/activity/activity1.png');?>" alt="">
                            <p><?php echo ($item["name"]); ?></p>
                        </a>
                    </div>
                    <div class="function-list">
                        <div class="list-box">
                            <?php if($item["status"] == 0): ?><a class="fuction" onclick="ck.release(<?php echo ($item["id"]); ?>);">发布</a>
                                <a class="fuction" onclick="ck.closure(<?php echo ($item["id"]); ?>);">结束</a>
                            <?php elseif($item["status"] == 1): ?>
                                <a class="fuction" onclick="ck.closure(<?php echo ($item["id"]); ?>);">结束</a><?php endif; ?>
                        </div>
                        <?php if($item["status"] == 0): ?><a class="fuction" href="<?php echo U('activity/create', array('activity_id'=>$item['id']));?>">编辑</a><?php endif; ?>
                    </div>
                </div><?php endforeach; endif; ?>
        </div>
    </div>
    <script>
        // 发布   // 结束
        (function(_){
            _.release = function(activity_id)
            {
                weui.confirm('确定发布该活动么?', function(){
                    $.post("<?php echo U('activity/release');?>", {activity_id: activity_id}, function(returnData){
                        ajaxReturnMsg(returnData, true);
                    });
                });
            };
            _.closure = function(activity_id)
            {
                weui.confirm('确定结束该活动么?', function(){
                    $.post("<?php echo U('activity/closure');?>", {activity_id: activity_id}, function(returnData){
                        ajaxReturnMsg(returnData, true);
                    });
                });
            };
        })(ck={});
    </script>

</body>

    <script>
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
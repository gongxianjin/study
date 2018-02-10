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
    <link rel="stylesheet" href="/mobile/style/my_integral.css">
    <title>我的积分</title>
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
    <span class="header-text">我的积分</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
        
    </span>
</div>


   <div class="page">
       <div class="page-content">
           <div class="page-content-img">
               <img src="/mobile/images/integral/coin2.png" alt="">
               <span class="coin-total"><?php echo ($score); ?></span>
           </div>
           <p class="down-aside">
               <a href="<?php echo U('shop/index');?>">去兑换商城礼品></a>
           </p>
       </div>
       <div class="content-tab-box">
           <div class="content-tab-header">
               <div class="tab-header-left cur"><a>收入</a></div>
               <div class="tab-header-right"><a>支出</a></div>
           </div>
           <div class="tab-content-lists">
               <?php if(is_array($detail)): foreach($detail as $key=>$item): if($item["type"] == 0): ?><div class="content-list">
                           <div class="list-top">
                               <div class="list-top-left">
                                   <?php echo ($item["content"]); ?> <span><?php echo ($item["score"]); ?></span>
                               </div>
                               <div class="list-top-right">+<?php echo ($item["score"]); ?></div>
                           </div>
                           <div class="list-down"><?php echo date('Y-m-d H:i:s', $item['time']);?></div>
                       </div><?php endif; endforeach; endif; ?>
           </div>

           <div class="tab-content-lists" style="display: none">
               <?php if(is_array($detail)): foreach($detail as $key=>$item): if($item["type"] == 1): ?><div class="content-list">
                           <div class="list-top">
                               <div class="list-top-left">
                                   <?php echo ($item["content"]); ?> <span><?php echo ($item["score"]); ?></span>
                               </div>
                               <div class="list-top-right">-<?php echo ($item["score"]); ?></div>
                           </div>
                           <div class="list-down"><?php echo date('Y-m-d H:i:s', $item['time']);?></div>
                       </div><?php endif; endforeach; endif; ?>
           </div>
       </div>
   </div>

    <script>
        $(".content-tab-header").on("click","div",function(){
            if(!$(this).hasClass("cur")){
                $(this).addClass("cur").siblings().removeClass("cur");
            }
            $($(".tab-content-lists")[$(this).index()]).css("display","block").siblings().css("display","none");
            $(".content-tab-header").css("display","flex");
        })
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
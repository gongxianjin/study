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
    
    <link rel="stylesheet" href="/mobile/style/public_index.css">

    <title>微论坛</title>
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
    <span class="header-text">微论坛</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
         <a href="<?php echo U('forum/edit');?>">发布话题</a> 
    </span>
</div>


    <div class="header-function">
        <div class="function-bar">
            <div class="bar-list active">
                <i class="txh icon-dongtai" style="font-size: 14px"></i>动态
            </div>
            <div class="bar-list">
                <i class="txh icon-remen1"></i>热门
            </div>
            <div class="bar-list">
                <i class="txh icon-faxian"></i>发现
            </div>
        </div>
    </div>

    <div class="page">
        <div class="page-content page-content-common" id="listWarp">
            <div class="function-banner"></div>
            <div class="topic-list-box" id="content"></div>
        </div>
    </div>

    <script>
        $(function(){
            $(".function-bar").on("click",".bar-list",function(){
                if(!($(this).hasClass("active"))){
                    $(this).addClass("active").siblings().removeClass("active");
                    $($(".page-content-common")[$(this).index()]).css("display","block").siblings().css("display","none");
                }
            });
            $(".tag-list-box").on("click",".tag-list",function(){
                if(!($(this).hasClass("active"))){
                    $(this).addClass("active").siblings().removeClass("active");
                }
            });
        });

        $(function(){
            var page = 0;
            $('#listWarp').dropload({
                scrollArea : window,
                loadDownFn : function(me){
                    page++;
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo U("forum/bbs_list");?>?p=' + page,
                        dataType: 'json',
                        success: function(data)
                        {
                            var is_data = true;
                            var content = data.data['content'] || [];
                            if( content.length )
                            {
                                is_data = false;
                                for(var item in content)
                                {
                                    $('#content').append($('<div class="topic-list"><div class="topic-list-title">' +
                                            '<div class="list-title-left"><div class="left-header">' +
                                            '<img src="' + content[item]['head_img'] + '" alt="">' +
                                            '</div>' +
                                            '<div class="left-username">' +
                                            '<p class="username">' + content[item]['nickname'] + '</p>' +
                                            '<p class="time">' + content[item]['time'] + '</p>' +
                                            '</div></div>' +
                                            '<div class="list-title-right"><a href="#">私信</a><a href="#">关注</a></div></div>' +
                                            '<div class="topic-list-content">' + content[item]['content'] + '</div>' +
                                            '<div class="topic-list-footer">' +
                                            '<a href="#"><i class="txh icon-pinglun"></i>' + content[item]['comments'] + '</a>' +
                                            '<a href="#"><i class="txh icon-zan"></i>' + content[item]['praise'] + '</a>' +
                                            '</div></div>  <div class="placeholder"></div>'));
                                }
                            }
                            me.lock();
                            me.noData(is_data);
                            me.resetload();
                        },
                        error: function(){
                            me.resetload();
                        }
                    });
                }
            });
        });
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
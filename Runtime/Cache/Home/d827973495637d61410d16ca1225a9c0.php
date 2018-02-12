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
    
    <link rel="stylesheet" href="/mobile/style/teacher_createclass.css">
    <?php $type = I('get.type', 0, 'intval'); $course_type_name = $type ? '课程' : '班级'; ?>

    <title>创建<?php echo ($course_type_name); ?></title>
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
    <span class="header-text">创建<?php echo ($course_type_name); ?></span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
         <a href="javascript:;" onclick="ck.submit();">保存</a> 
    </span>
</div>

    <div class="page">
        <div class="class-name">
            <label><?php echo ($course_type_name); ?>名称</label>
            <input type="text" name="class_name" maxlength="20" style="border: 1px solid #808080;" placeholder="输入<?php echo ($course_type_name); ?>名称">
        </div>
        <?php if($type): ?><div class="class-name">
                <label><?php echo ($course_type_name); ?>介绍</label>
                <input type="text" name="class_describe" maxlength="50"
                       style="border: 1px solid #808080;" placeholder="输入<?php echo ($course_type_name); ?>介绍">
            </div>
            <div class="class-name">
                <label><?php echo ($course_type_name); ?>保证金</label>
                <input type="number" name="class_price" maxlength="10"
                       style="border: 1px solid #808080;" placeholder="输入<?php echo ($course_type_name); ?>保证金">
            </div><?php endif; ?>
        <div class="placeholder"></div>
        <div class="class-name">
            <label><?php echo ($course_type_name); ?>封面</label>
            <input type="hidden" name="class_img" value="" />
            <div class="images" id="search_cover">
                点击此处添加<?php echo ($course_type_name); ?>封面
            </div>
        </div>
    </div>
    </div>
    <div class="placeholder"></div>
    </div>
    <script type="text/javascript">
        layui.use(['upload'], function(){
            layui.upload.render({
                elem: '#search_cover'
                ,field: 'head_img'
                ,url: '<?php echo U("upload/head_img");?>'
                ,before: function(obj){
                    obj.preview(function(index, file, result){
                        $("#search_cover").html($('<img src="'+ result +'"  />'));
                        layer.load(0, {shade: 0.6});
                    });
                },done: function(ret){
                    layer.closeAll();
                    if((typeof ret.code) == undefined)
                    {
                        weui.alert('上传异常');
                        return;
                    }
                    if( ret.code )
                    {
                        weui.alert(ret.message);
                        return;
                    }
                    $('input[name="class_img"]').val(ret.filename);
                }
            });
        });

        (function(_){
            _.submit = function()
            {
                var class_name = $('input[name="class_name"]').val();
                if( ! class_name ){
                    weui.alert('请填写<?php echo ($course_type_name); ?>名称');
                    return;
                }

                var class_img = $('input[name="class_img"]').val();
                if( ! class_img ){
                    weui.alert('请选择<?php echo ($course_type_name); ?>封面');
                    return;
                }

                $.post("<?php echo U('grade/createClass');?>", {
                    type: parseInt("<?php echo I('get.type', 0, 'intval');?>"),
                    class_name: class_name,
                    class_img: class_img,
                    class_price: $('input[name="class_price"]').val(),
                    class_describe: $('input[name="class_describe"]').val()
                }, function(returnData){
                    ajaxReturnMsg(returnData);
                });
            }
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
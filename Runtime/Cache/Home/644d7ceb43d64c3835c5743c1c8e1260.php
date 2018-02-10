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
    
    <!--<link rel="stylesheet" href="/mobile/style/homework.css">-->
    <link rel="stylesheet" href="/mobile/layui/css/layui.css">
    <script type="text/javascript" src="/mobile/layui/layui.js"></script>

    <title>布置作业</title>
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
    <span class="header-text">布置作业</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
        
    </span>
</div>

    <div class="page" style="top: 55px;">

        <div style="width: 96%; margin: auto;">
            <form class="layui-form">
                <input type="hidden" name="grade_id" value="<?php echo I('get.grade_id', 0, 'intval');?>" />
                <label>第一步：选择课本</label>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择课本</label>
                    <div class="layui-input-block">
                        <select name="book_id"  lay-filter="province" lay-verify="required">
                            <option value=""></option>
                            <?php echo W('Select/bookList');?>
                        </select>
                    </div>
                </div>

                <hr/>
                <label>第二步：选择起始截止课文</label>
                <div class="layui-form-item">
                    <label class="layui-form-label">起始课文</label>
                    <div class="layui-input-block">
                        <select name="start_book" lay-verify="required">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">结束课文</label>
                    <div class="layui-input-block">
                        <select name="end_book" lay-verify="required">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <hr/>
                <div class="layui-form-item">
                    <label class="layui-form-label">录音课文</label>
                    <div class="layui-input-block">
                        <input type="text" name="count" required
                               lay-verify="required" placeholder="每日录音课文数" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">重复天数</label>
                    <div class="layui-input-block">
                        <input type="text" name="day" required
                               lay-verify="required" placeholder="重复天数" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <button class="layui-btn" type="submit"  style="width: 100%; margin: 20px 0 50px;"
                        lay-submit="" lay-filter="formDemo">保存</button>
            </form>
        </div>

    </div>

    <script type="text/javascript">

        layui.use(['form'], function(){
            var form = layui.form;
            form.on('select(province)', function(data){
                $.getJSON("<?php echo U('library/bookRes');?>", {book_id: data.value}, function(returnData){
                    var options = "";
                    $.each(returnData.data, function(index, value)
                    {
                        options += "<option value='"+index+"'>"+value+"</option>";
                    });
                    $('select[name="start_book"]').html(options);
                    $('select[name="end_book"]').html(options);
                    form.render('select');
                });
            });

            form.on('submit(formDemo)', function(data){
                $.post("<?php echo U('library/setTask');?>", data.field, function(returnData){
                    ajaxReturnMsg(returnData);
                });
                return false;
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
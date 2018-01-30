<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>班级详情</title>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/class_detail.css">
    <script type="text/javascript" src="/mobile/layui/layui.js"></script>
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
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">班级详情</span>
    <!--右侧按钮-->
<!--     <span class="header-btn">
        <a style="font-weight: normal;">
           <i class="txh icon-share"></i>
        </a>
    </span> -->

</div>

<div class="page">
    <div class="class-name">
        <label>班级名称</label>
        <input type="text" placeholder="21天预备班" name="class_name" value="<?php echo ($class['class_name']); ?>">
    </div>

    <div class="textarea-box">
        <label>班级简介</label>
        <textarea class="weui-textarea" placeholder="这是一个很好的班级" rows="3" name="class_desc"></textarea>
    </div>
    <div class="uploader js_show">
        <div class="page__bd">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__hd">
                                <p class="weui-uploader__title">班级头像</p>
                            </div>
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files" id="uploaderFiles">

                                    <li class="weui-uploader__file" style="background-image:url(<?php echo imageDomain($class['image']);?>)">
                                    </li>
                                </ul>
                                <div class="weui-uploader__input-box" id="head_img_div">
                                    <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="" name="head_img">
                                    <input type="hidden" name="head_img_name" value="<?php echo ($class['image']); ?>">
                                    <input type="hidden" name="class_id" value="<?php echo ($class['class_id']); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="footer-box">
    <a href="#" id="addClass">保存</a>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>
<script type="text/javascript" class="uploader js_show">
    $(function(){
        var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"></li>',
            $uploaderInput = $("#uploaderInput"),
            $uploaderFiles = $("#uploaderFiles")
        ;

        $uploaderInput.on("change", function(e){
            var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
            for (var i = 0, len = files.length; i < len; ++i) {
                var file = files[i];

                if (url) {
                    src = url.createObjectURL(file);
                } else {
                    src = e.target.result;
                }
                $(".weui-uploader__files").html("");
                /*$uploaderFiles.append($(tmpl.replace('#url#', src)));*/
                $uploaderFiles.append($(tmpl.replace('#url#', src)));
            }
        });
            layui.use(['upload'], function(){
                layui.upload.render({
                    elem: '#uploaderInput'
                    ,field: 'head_img'
                    ,url: '<?php echo U("upload/head_img");?>'
                    ,before: function(obj){
                        obj.preview(function(index, file, result){
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
                        
                        $('input[name="head_img_name"]').val(ret.filename);
                    }
                });
            });

        //创建班级
        $('#addClass').on('click',function(){
            var head_img = $('input[name="head_img_name"]').val();
            if( ! head_img ){
                weui.alert('请选择头像');
            }
            var class_name = $('input[name="class_name"]').val();
            if( ! class_name ){
                weui.alert('请填写昵称');
            }

            $.post("<?php echo U('Home/MyClass/saveClass');?>",{
                head_img: head_img,
                class_name: $('input[name="class_name"]').val(),
                class_desc: $('textarea[name="class_desc"]').val(),
                class_id: $('input[name="class_id"]').val(),
            },function(returnData){
                ajaxReturnMsg(returnData);
            });

        });

    });
</script>

</html>
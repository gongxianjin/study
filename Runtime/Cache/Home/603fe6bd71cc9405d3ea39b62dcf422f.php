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
    
    <link rel="stylesheet" href="/mobile/style/public.css">

    <title>发布话题</title>
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
    <span class="header-text">发布话题</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
         <a href="javascript:;" onclick="ck.submit();" id="upload">发布</a> 
    </span>
</div>


    <div class="page">
        <div class="instruct_text">
            免责声明：本平台发布的所有信息（收费、免费）展示，内容本身与平台无关，平台不负任何责任。
        </div>
        <div class="textarea-box">
            <textarea class="weui-textarea" name="content" placeholder="请输入文本" rows="5"></textarea>
        </div>
        <div class="uploader js_show" id="uploader">
            <div class="page__bd">
                <div class="weui-cells weui-cells_form">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <div class="weui-uploader">
                                <div class="weui-uploader__hd">
                                    <p class="weui-uploader__title">上传图片</p>
                                    <div class="weui-uploader__info">最多上传9张照片</div>
                                </div>
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files" id="uploaderFiles"></ul>
                                    <div class="weui-uploader__input-box">
                                        <input id="uploaderInput" class="weui-uploader__input"
                                               type="file" accept="image/*" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" class="uploader js_show">
        var uploadCount = 0;

        var layer;
        layui.use(['layer'], function(){
            layer = layui.layer;
        });

        weui.uploader('#uploader', {
            url: '<?php echo U("upload/head_img");?>',
            auto: true,
            type: 'file',
            fileVal: 'head_img',
            onBeforeQueued: function(files) {
                if(["image/jpg", "image/jpeg", "image/png", "image/gif"].indexOf(this.type) < 0)
                {
                    weui.alert('请上传图片');
                    return false;
                }
                if(this.size > 10 * 1024 * 1024)
                {
                    weui.alert('请上传不超过10M的图片');
                    return false;
                }
                if (files.length > 9)
                {
                    weui.alert('最多只能上传9张图片，请重新选择');
                    return false;
                }
                if (uploadCount + 1 > 9)
                {
                    weui.alert('最多只能上传9张图片');
                    return false;
                }
                ++uploadCount;
                return true;
            },
            onQueued: function(){
                var tmp = '<li class="weui-uploader__file" style="background-image:url(#url#)">' +
                        '<input type="hidden" name="images[]" id="images_'+ this.id +'" value="" /></li>';
                $("#uploaderFiles").append($(tmp.replace('#url#', this.url)).click(function(){
                    $(this).remove();
                }));
                return true;
            },onBeforeSend: function(){
                layer.load(0, {shade: 0.6});
            },
            onSuccess: function (ret){
                layer.closeAll();
                if( ret.code != 0){
                    return ;
                }
                $('#images_' + this.id).val(ret.filename);
            }
        });

        (function(_){

            _.submit = function()
            {
                var content = $('textarea[name="content"]').val();
                var images = $('input[name="images[]"]');

                var img = [];
                for(var i = 0 ; i < images.length ; i+=1)
                {
                    img.push( images.eq(i).val() );
                }

                layer.load(0, {shade: 0.6});
                $.post("<?php echo U('forum/release');?>", {content: content, images: img}, function(returnData)
                {
                    layer.closeAll();
                    ajaxReturnMsg(returnData);
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
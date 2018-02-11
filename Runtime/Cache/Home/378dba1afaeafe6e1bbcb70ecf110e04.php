<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/choice_address.css">
    <title>选择收货地址</title>
</head>
<body>

<div class="header">
    <div class="header-functionBar">
        <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
        <!--中间文字-->
        <span class="header-text">选择收货地址</span>
        <!--右侧按钮-->
        <span class="header-btn">
            <a href="<?php echo U('address/set');?>" style="font-size: 30px;">+</a>
        </span>
    </div>
</div>
<div class="page">
    <div class="content-box" style="background: none;">
        <?php if(is_array($showData)): foreach($showData as $key=>$item): ?><div class="weui-form-preview">
                <?php if(isset($callback)): ?><a href="<?php echo ($callback); echo ($item["id"]); echo C('TMPL_TEMPLATE_SUFFIX');?>"><?php endif; ?>
                <div class="weui-form-preview__bd">
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label"><?php echo ($item["name"]); ?></label>
                        <span class="weui-form-preview__value edit-text"><?php echo ($item["phone"]); ?></span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label edit-text address-text">
                            <?php echo ($item["address"]); ?>
                        </label>
                    </div>
                </div>
                <?php if(isset($callbaack)): ?></a><?php endif; ?>
                <div class="weui-form-preview__ft">
                    <a class="<?php echo ($item['def']?'active':''); ?> weui-form-preview__btn weui-form-preview__btn_default"
                         href="javascript:" onclick="ck.setDefault(<?php echo ($item["id"]); ?>);" >
                        <i class="txh icon-wancheng1"></i>默认地址
                    </a>
                    <div class="right-edit">
                        <a class="edit" href="<?php echo U('address/set', array('address_id'=>$item['id']));?>">
                            <i class="txh icon-bianji" style="font-size: 13px;margin-right: 2px"></i>编辑
                        </a>
                        <div class="remove" onclick="ck.remove(<?php echo ($item["id"]); ?>);"><i class="txh icon-shanchu"></i> 删除</div>
                    </div>
                </div>
            </div>
            <div class="content-holder"></div><?php endforeach; endif; ?>
    </div>
</div>
</body>
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
<script type="text/javascript" src="/mobile/layer/layer.js"></script>
<script>
    (function(_){
        _.setDefault = function(address_id)
        {
            $.get("<?php echo U('address/set_default');?>", {address_id: address_id}, function(returnData){
                ajaxReturnMsg(returnData, true);
            });
        };
        _.remove = function(address_id)
        {
            layer.open({
                content: '确定删除该收件地址么？'
                ,btn: ['删除', '取消']
                ,skin: 'footer'
                ,yes: function(index)
                {
                    layer.close(index);
                    $.post("<?php echo U('address/remove');?>", {address_id: address_id}, function(returnData){
                        ajaxReturnMsg(returnData, true);
                    });

                }
            });
        };
    })(ck={});
</script>
</html>
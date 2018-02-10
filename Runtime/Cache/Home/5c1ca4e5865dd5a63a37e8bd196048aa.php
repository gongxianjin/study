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
    <link rel="stylesheet" href="/mobile/style/person_infor.css">
    <title>个人信息设置</title>
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
    <span class="header-text">个人信息设置</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
        <a  id="saveBtn" style="font-weight: normal;color: #3972a8;">保存</a>
    </span>
</div>


  <div class="page">
      <div class="weui-cells basic-info">

          <a class="weui-cell weui-cell_access" href="javascript:;"  id="upload_hd">
              <div class="weui-cell__hd">
                  头像
              </div>
              <div class="weui-cell__bd weui-cell_primary">
                  <div class="header-img" >
                        <span>
                            <img id="head_img" src="<?php echo imageDomain($userInfo['head_img']);?>" alt="">
                            <input id="head_img_value" name="head_img" value="<?php echo ($userInfo["head_img"]); ?>" type="hidden">
                            <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*">
                        </span>
                  </div>
              </div>
              <span class="weui-cell__ft"></span>
          </a>

          <a class="weui-cell weui-cell_access" href="javascript:;">
              <div class="weui-cell__hd">
                  昵称
              </div>
              <div class="weui-cell__bd weui-cell_primary">
                  <input class="weui-input" type="text" name="nickname"
                         style="text-align: right;" maxlength="10" value="<?php echo ($userInfo["nickname"]); ?>" />
              </div>
              <span class="weui-cell__ft"></span>
          </a>

          <a id="search_sex" class="weui-cell weui-cell_access" href="javascript:;">
              <div class="weui-cell__hd">
                  性别
              </div>
              <div class="weui-cell__bd weui-cell_primary">
                  <input type="text" class="weui-input" style="text-align: right;"  name="sex" id="sex_value"
                         readonly="readonly" value="<?php echo ($userInfo['sex']=='1') ? '男' :($userInfo['sex']==2?'女':'');?>" />
              </div>
              <span class="weui-cell__ft"></span>
          </a>
          <a class="weui-cell weui-cell_access" id="search_birthday" href="javascript:;">
              <div class="weui-cell__hd">
                  生日
              </div>
              <div class="weui-cell__bd weui-cell_primary">
                  <input type="text" value="<?php echo ($userInfo["birthday"]); ?>" class="weui-input" name="birthday"
                         style="text-align: right;" readonly="readonly" id="birthday_value_input" />
              </div>
              <span class="weui-cell__ft"></span>
          </a>
      </div>
      <div class="weui-cells basic-info">
          <a class="weui-cell weui-cell_access" href="javascript:;">
              <div class="weui-cell__hd">
                  地区
              </div>
              <div class="weui-cell__bd weui-cell_primary">
                  <input class="weui-input" type="text" name="city" id='city-picker'
                         style="text-align: right;" maxlength="10" value="<?php echo ($userInfo["city"]); ?>" />
              </div>
              <span class="weui-cell__ft"></span>
          </a>
      </div> 
      <div class="weui-cells basic-info">
          <a class="weui-cell weui-cell_access" href="<?php echo U('login/loginout');?>">
              <div class="weui-cell__hd">
                  退出
              </div> 
          </a>
      </div>
  </div>

    <script>
        $('#saveBtn').on('click', function(){ 
            var head_img = $('input[name="head_img"]').val();
            if( ! head_img ){
                weui.alert('请选择头像');
            }
            var nickname = $('input[name="nickname"]').val();
            if( ! nickname ){
                weui.alert('请填写昵称');
            }
            $.post("<?php echo U('user/setPersonal');?>", {
                head_img: head_img,
                nickname: nickname,
                sex: $('input[name="sex"]').val(),
                birthday: $('input[name="birthday"]').val(),
                city: $('input[name="city"]').val()
            }, function(returnData){
                ajaxReturnMsg(returnData);
            });
        });

        $('#city-picker').on('click',function(){
            weui.picker(province(), {
                onConfirm: function (result) {
                    $('#city-picker').val(result.join(" "));
                }});
        });

        $('#search_sex').on('click', function () {
            var sexType = 1;
            if($('#sex_value').val() == '女'){
                sexType = 2;
            }
            weui.picker([{label: '男', value: 1}, {label: '女', value: 2}],{
                defaultValue: [sexType],
                onConfirm: function (result) {
                    $('#sex_value').val(result[0] == 1 ? '男' : '女');
                }});
        });

        $('#search_birthday').on('click', function () {
            var year = (new Date()).getFullYear();
            weui.datePicker({
                start: year - 100,
                end: year,
                onConfirm: function (result)
            {
                $('#birthday_value_input').val(result[0]+'-'+result[1]+'-'+result[2]);
            }});
        });

        weui.uploader('#upload_hd', {
            url: '<?php echo U("upload/head_img");?>',
            auto: true,
            type: 'file',
            fileVal: 'head_img',
            onQueued: function(){
                $('#head_img').attr('src', this.url);
            },onBeforeSend: function(){
                $("#loading_text").html('头像上传中');
                $("#loadingToast").fadeIn(100);
            },onSuccess: function (ret){
                $("#loadingToast").fadeOut(100);
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
                $('#head_img_value').val(ret.filename);
                return true;
            }
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
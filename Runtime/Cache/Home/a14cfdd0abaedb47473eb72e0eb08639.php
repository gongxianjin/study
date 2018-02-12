<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/integral_manager_person.css">
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
    <title>管理个人积分</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">管理个人积分</span>
    <!--右侧按钮-->
     <span class="header-btn">
            <a style="font-weight: normal">
                <i class="txh icon-share"></i>
            </a>
    </span>

</div>
<div class="page-content">
    <div class="page-content-img">
        <img src="/mobile/images/integral/coin2.png" alt="">
        <span class="coin-total"><?php echo ($res['name']); ?>积分</span>
    </div>
    <p><span>可兑总积分<strong><?php echo ($res['score']); ?></strong></span><span>已兑积分<strong><?php echo ($res['usedScore']); ?></strong></span></p>


</div>
<div class="page">
    <div class="content-tab-box">
        <table class="imagetable">
            <tbody>
            <tr class="th_bg">
                <th>积分</th>
                <th>兑奖</th>
                <th>数量</th>
                <th>时间</th>
            </tr>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><tr>
                    <td class="add_interger">
                        <?php echo ($s['score']); ?>
                    </td>
                    <td>
                        <?php echo ($s['source']); ?>
                    </td>
                    <td><?php echo ($s['value']); ?></td>
                    <td><?php echo ($s['time']); ?></td>

                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="footer">
    <a href="#" id="prise">奖励积分</a>
</div>
<div class="js_dialog" id="iosDialog1" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-dialog">
        <div class="weui-dialog__hd"><strong class="weui-dialog__title">送积分奖励</strong></div>
        <div class="weui-dialog__bd">
            <div class="weui-cells ">
                <div class="weui-cell interger-list-box">
                    <div class="interger-list active">
                        <i class="txh icon-jifen"></i>
                        <p>
                            <span>5</span>
                            积分
                        </p>
                    </div>
                    <div class="interger-list">
                        <i class="txh icon-jifen"></i>
                        <p>
                            <span>10</span>
                            积分
                        </p>
                    </div>
                    <div class="interger-list">
                        <i class="txh icon-jifen"></i>
                        <p>
                            <span>15</span>
                            积分
                        </p>
                    </div>
                </div>
                <div class="weui-cell">
                    <textarea class="weui-textarea" style="outline:none;height: 80px;
border: 1px solid #e8e8e8;
box-sizing: border-box;color: #999999;font-weight: 300;padding: 10px;border-radius: 4px" id="content">请输入备注</textarea>
                </div>
                <input type="hidden" id="stu_id" value="<?php echo ($res['id']); ?>">
                <input type="hidden" id="score" value="5">
                <div class="weui-cell">
                    <a href="#" class="queren" id="addScore">确定</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script>
    $(".interger-list-box").on("click",".interger-list",function () {
        $(this).addClass("active").siblings().removeClass("active");
        $('#score').val( ($(this).index() + 1) * 5 );
    });
    $(".content-tab-header").on("click","div",function(){
        if(!$(this).hasClass("cur")){
            $(this).addClass("cur").siblings().removeClass("cur");
        }
        $($(".tab-content-lists")[$(this).index()]).css("display","block").siblings().css("display","none");
        $(".content-tab-header").css("display","flex");
    });
    $("#prise").on("click",function () {
        var $iosDialog1 = $('#iosDialog1');
        $iosDialog1.fadeIn(200);
    });
    $(".queren").on("click",function () {
        var $iosDialog1 = $('#iosDialog1');
        $iosDialog1.fadeOut(200);
    });
    $(".weui-mask").on("click",function () {
        var $iosDialog1 = $('#iosDialog1');
        $iosDialog1.fadeOut(200);
    });

    //分数提交
    $('#addScore').click(function (){
        $.post("<?php echo U('Home/MyClass/awardScore');?>",{
            user_id:$('#stu_id').val(),
            score:$('#score').val(),
            content:$('#content').val()
            },function(res){
                ajaxReturnMsg(res);
            });
    });
</script>

</html>
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
    
    <link rel="stylesheet" href="/mobile/style/book.css">

    <title>我的作业</title>
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
    <span class="header-text">我的作业</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
         <a id="submit" href="#">提交</a>
    </span>
</div>

    <div class="page">
        <div class="img-box">
            <img src="<?php echo imageDomain($showData['content_img']);?>" alt="">
        </div>
    </div>
    <input type="hidden"  id="mp3voicefile" value=""/>
    <div class="footer">
        <div class="pagetion"><span>11</span>/<span>20</span></div>
        <div class="line"><img src="/mobile/images/line.png" alt=""></div>
        <div class="weui-tabbar">
            <a href="javascript:;" class="weui-tabbar__item">
                <img src="/mobile/images/voice.png" alt="" class="weui-tabbar__icon" style="margin-top: 14px;">
                <p class="weui-tabbar__label">听原音</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item" id="talk_btn">
                    <span style="display: inline-block;position: relative;">
                        <img src="/mobile/images/luyin.png" alt="" class="weui-tabbar__icon" style="width: 40px;height: 34px">
                    </span>
                <p class="weui-tabbar__label">录制</p>
            </a>
            <a href="javascript:;" class="weui-tabbar__item" id="playVoice">
                <img src="/mobile/images/shiting.png" alt="" class="weui-tabbar__icon" style="margin-top: 14px;">
                <p class="weui-tabbar__label">试听</p>
            </a>
        </div>
    </div>
    <div class="js_dialog" id="iosDialog1" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__hd">
                <img style="width: 100%" src="/mobile/images/activity/dialog_hd.png" alt="">
            </div>
            <div class="weui-dialog__bd">
                <div>本次作业获得30颗星星</div>
            </div>
            <div class="weui-dialog__ft">
                <a href="#">
                    返回
                </a>
                <a href="#">完成</a>
            </div>
        </div>
    </div>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="http://203.195.235.76/jssdk/js/zepto.min.js"></script>
    <script>
        $(function(){
            var $iosDialog1 = $('#iosDialog1');
            $('#submit').on('click', function(){
                var content_voice = $('#mp3voicefile').val();
                if (content_voice == '') {
                    alert('请上传录音');
                    return;
                }
                $.post("<?php echo U('student/addRes');?>", {
                    hid: parseInt("<?php echo I('get.taskid', 0, 'intval');?>"),
                    content_voice: content_voice
                }, function(returnData){
                    ajaxReturnMsg(returnData);
                });
                $iosDialog1.fadeIn(200);
            });
            $(".weui-mask").on('click',function () {
                $iosDialog1.fadeOut(200);
            })
        })
        var ele = document.getElementsByClassName("img-box")[0];
        var beginX, beginY, endX, endY, swipeLeft, swipeRight;
        ele.addEventListener('touchstart', function (event) {
            event.stopPropagation();
            event.preventDefault();
            beginX = event.targetTouches[0].screenX;
            beginY = event.targetTouches[0].screenY;
            swipeLeft = false, swipeRight = false;
        });

        ele.addEventListener('touchmove', function (event) {
            event.stopPropagation();
            event.preventDefault();
            endX = event.targetTouches[0].screenX;
            endY = event.targetTouches[0].screenY;
            // 左右滑动
            if (Math.abs(endX - beginX) - Math.abs(endY - beginY) > 0) {
                /*向右滑动*/
                if (endX - beginX > 0) {
                    swipeRight = true;
                    swipeLeft = false;
                    alert(11)
                }
                /*向左滑动*/
                else {
                    swipeLeft = true;
                    swipeRight = false;
                    alert(22)
                }
            }
        });
        ele.addEventListener('touchend', function (event) {
            event.stopPropagation();
            event.preventDefault();
            if (Math.abs(endX - beginX) - Math.abs(endY - beginY) > 0) {
                event.stopPropagation();
                event.preventDefault();if (swipeRight) {
                    swipeRight = !swipeRight;
                    /*向右滑动*/
                    alert(11)
                }
                if(swipeLeft) {
                    swipeLeft = !swipeLeft;
                    /*向左滑动*/
                    alert(2)
                }
            }
        });

        wx.config({
            debug: true,
            appId: '<?php echo ($signPackage["appId"]); ?>',
            timestamp:'<?php echo ($signPackage["timestamp"]); ?>',
            nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
            signature: '<?php echo ($signPackage["signature"]); ?>',
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'translateVoice',
                'startRecord',
                'stopRecord',
                'onVoiceRecordEnd',
                'playVoice',
                'uploadVoice',
                'onVoicePlayEnd',
            ]
        });

        var START = '',
            recordTimer = 0,
            END = '';
        wx.ready(function () {
            var voice = {
                localId: '',
                serverId: '',
            };
            // 4 音频接口
            // 4.2 开始录音
//            document.querySelector('#startRecord').onclick = function () {
//                wx.startRecord({
//                    cancel: function () {
//                        alert('用户拒绝授权录音');
//                    }
//                });
//            };
            //假设全局变量已经在外部定义
            //按下开始录音
            $('#talk_btn').on('touchstart', function(event){
                event.preventDefault();
                START = new Date().getTime();

                recordTimer = setTimeout(function(){
                    wx.startRecord({
                        success: function(){
                            localStorage.rainAllowRecord = 'true';
                        },
                        cancel: function () {
                            alert('用户拒绝授权录音');
                        }
                    });
                },300);
            });
            //松手结束录音
            $('#talk_btn').on('touchend', function(event){
                event.preventDefault();
                END = new Date().getTime();

                if((END - START) < 300){
                    END = 0;
                    START = 0;
                    //小于300ms，不录音
                    clearTimeout(recordTimer);
                }else{
                    wx.stopRecord({
                        success: function (res) {
                            voice.localId = res.localId;
                            uploadVoice();
                        },
                        fail: function (res) {
                            alert(JSON.stringify(res));
                        }
                    });
                }
            });

            //上传录音
            function uploadVoice(){
                //调用微信的上传录音接口把本地录音先上传到微信的服务器
                //不过，微信只保留3天，而我们需要长期保存，我们需要把资源从微信服务器下载到自己的服务器
                wx.uploadVoice({
                    localId: voice.localId, // 需要上传的音频的本地ID，由stopRecord接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        //把录音在微信服务器上的id（res.serverId）发送到自己的服务器供下载。
                        $.ajax({
                            url: '<?php echo U("student/savevoice");?>',
                            type: 'post',
                            data: JSON.stringify(res),
                            dataType: "json",
                            success: function (data) {
                                if(data.code == 1){
                                    $('#mp3voicefile').attr('value',data.data.content);
                                }
                                alert('文件已经保存到服务器');//这回，我使用七牛存储
                            },
                            error: function (xhr, errorType, error) {
                                console.log(error);
                            }
                        });
                    }
                });
            }

            //注册微信播放录音结束事件【一定要放在wx.ready函数内】
            wx.onVoicePlayEnd({
                success: function (res) {
                    stopWave();
                }
            });


            // 4.3 停止录音
//            document.querySelector('#stopRecord').onclick = function () {
//                wx.stopRecord({
//                    success: function (res) {
//                        voice.localId = res.localId;
//                    },
//                    fail: function (res) {
//                        alert(JSON.stringify(res));
//                    }
//                });
//            };
//
//            // 4.4 监听录音自动停止
//            wx.onVoiceRecordEnd({
//                complete: function (res) {
//                    voice.localId = res.localId;
//                    alert('录音时间已超过一分钟');
//                }
//            });
//
            // 4.5 播放音频
            document.querySelector('#playVoice').onclick = function () {
                if (voice.localId == '') {
                    alert('请先使用 startRecord 接口录制一段声音');
                    return;
                }
                wx.playVoice({
                    localId: voice.localId
                });
            };

        
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
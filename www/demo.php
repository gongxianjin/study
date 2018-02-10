<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx16fc38c94890b6a3", "a4d5065875424044e5b9a0b2a654719c");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>微信JS-SDK Demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" href="http://203.195.235.76/jssdk/css/style.css">
</head>
<body>
<div class="wxapi_container">
  <div class="wxapi_index_container">
    <ul class="label_box lbox_close wxapi_index_list">
      <li class="label_item wxapi_index_item"><a class="label_inner" href="#menu-voice">音频接口</a></li>
    </ul>
  </div>
  <div class="lbox_close wxapi_form">
    <h3 id="menu-voice">音频接口</h3>
    <span class="desc">开始录音接口</span>
    <button class="btn btn_primary" id="startRecord">startRecord</button>
    <span class="desc">停止录音接口</span>
    <button class="btn btn_primary" id="stopRecord">stopRecord</button>
    <span class="desc">播放语音接口</span>
    <button class="btn btn_primary" id="playVoice">playVoice</button>
    <span class="desc">暂停播放接口</span>
    <button class="btn btn_primary" id="pauseVoice">pauseVoice</button>
    <span class="desc">停止播放接口</span>
    <button class="btn btn_primary" id="stopVoice">stopVoice</button>
    <span class="desc">上传语音接口</span>
    <button class="btn btn_primary" id="uploadVoice">uploadVoice</button>
    <span class="desc">下载语音接口</span>
    <button class="btn btn_primary" id="downloadVoice">downloadVoice</button>
  </div>
</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'translateVoice',
      'startRecord',
      'stopRecord',
      'onVoiceRecordEnd',
      'playVoice',
      'onVoicePlayEnd',
      'pauseVoice',
      'stopVoice',
      'uploadVoice',
      'downloadVoice',
    ]
  });
</script>
<script src="http://203.195.235.76/jssdk/js/zepto.min.js"></script> 
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 如有问题请通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.ready(function () {
    var voice = {
      localId: '',
      serverId: ''
    };
    // 4 音频接口
    // 4.2 开始录音
    document.querySelector('#startRecord').onclick = function () {
      wx.startRecord({
        cancel: function () {
          alert('用户拒绝授权录音');
        }
      });
    };

    // 4.3 停止录音
    document.querySelector('#stopRecord').onclick = function () {
      wx.stopRecord({
        success: function (res) {
          voice.localId = res.localId;
        },
        fail: function (res) {
          alert(JSON.stringify(res));
        }
      });
    };

    // 4.4 监听录音自动停止
    wx.onVoiceRecordEnd({
      complete: function (res) {
        voice.localId = res.localId;
        alert('录音时间已超过一分钟');
      }
    });

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

    // 4.6 暂停播放音频
    document.querySelector('#pauseVoice').onclick = function () {
      wx.pauseVoice({
        localId: voice.localId
      });
    };

    // 4.7 停止播放音频
    document.querySelector('#stopVoice').onclick = function () {
      wx.stopVoice({
        localId: voice.localId
      });
    };

    // 4.8 监听录音播放停止
    wx.onVoicePlayEnd({
      complete: function (res) {
        alert('录音（' + res.localId + '）播放结束');
      }
    });

    // 4.8 上传语音
    document.querySelector('#uploadVoice').onclick = function () {
      if (voice.localId == '') {
        alert('请先使用 startRecord 接口录制一段声音');
        return;
      }
      wx.uploadVoice({
        localId: voice.localId,
        success: function (res) {
          alert('上传语音成功，serverId 为' + res.serverId);
          voice.serverId = res.serverId;
        }
      });
    };

    // 4.9 下载语音
    document.querySelector('#downloadVoice').onclick = function () {
      if (voice.serverId == '') {
        alert('请先使用 uploadVoice 上传声音');
        return;
      }
      wx.downloadVoice({
        serverId: voice.serverId,
        success: function (res) {
          alert('下载语音成功，localId 为' + res.localId);
          voice.localId = res.localId;
        }
      });
    };
  });
  wx.error(function (res) {
    alert(res.errMsg);
  });
</script>
</html>

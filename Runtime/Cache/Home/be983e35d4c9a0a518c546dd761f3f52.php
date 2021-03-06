<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>活动详情</title>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/activity.css">
</head>
<body>
<div class="header">
    <span class="header-back" onclick="window.history.back();">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <span class="header-text">活动详情</span>
</div>

<div class="page">
    <div class="page-banner">
        <img src="/mobile/images/activity/activity_banner.png" alt="">
        <p class="banner-text"><?php echo ($name); ?></p>
    </div>
    <div class="sign_up_people">
        <div class="sign_up_left">
            2018人已经报名
        </div>
    </div>
    <div class="placeholder"></div>
    <div class="activity-detail">
        <div class="activity-detail-title">
            活动详情
        </div>
        <div class="activity-detail-content">
            <p style="margin-bottom: 15px">
                <?php echo ($content); ?>
            </p>
        </div>
    </div>
</div>

<!-- 只允许学生报名 -->
<?php if($user_type == 0): ?><div class="footer">
        <a href="<?php echo U('activity/curriculum', array('activity_id'=>$id));?>">
            <i class="txh icon-addpeople"></i>点击选择课程
        </a>
    </div><?php endif; ?>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script>

</script>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>班级详情</title>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/manager_classthing.css">
</head>
<body>
<div class="header">
    <span class="header-btn">
            <a href="#"><i class="txh icon-share"></i></a>
    </span>
    <a href="class_detail.html" class="header-img">
        <div style="width: 90px;height: 90px;overflow: hidden" class="teacher-header">
            <img src="<?php echo imageDomain($class['image']);?>" alt="">
        </div>
        <p style="margin-top: 0"><?php echo ($class['class_name']); ?></p>
    </a>
</div>
<div class="page">
    <div class="weui-tabbar page-tabber">
        <a href="<?php echo U('MyClass/todayWork',array('class_id' => $class['class_id']));?>" class="weui-tabbar__item">
            <img style="width: 24px" src="/mobile/images/person/icon3.png" alt="" class="weui-tabbar__icon">
            <p class="weui-tabbar__label">今日作业预览</p>
        </a>
        <a href="<?php echo U('Home/MyClass/addStudent',array('class_id' => $class['class_id']));?>" class="weui-tabbar__item">
            <i style="color:#F4BC43;font-size: 20px" class="txh icon-tianjiachengyuan weui-tabbar__icon"></i>
            <p class="weui-tabbar__label">添加成员</p>
        </a>
        <a href="<?php echo U('Home/MyClass/homeworkManager',array('class_id' => $class['class_id']));?>" class="weui-tabbar__item">
            <i style="color:#A98DE4;font-size: 20px" class="txh icon-book weui-tabbar__icon"></i>
            <p class="weui-tabbar__label">班级作业</p>
        </a>

    </div>
    <div class="page-placeholder"></div>
    <div class="content-tab-box">
        <table class="imagetable">
            <tbody>
            <tr class="th_bg">
                <th>排名</th>
                <th>用户</th>
                <th>昵称</th>
                <th>手机号</th>
                <th>角色</th>
            </tr>
            <?php if(is_array($stuList)): $i = 0; $__LIST__ = $stuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$stu): $mod = ($i % 2 );++$i;?><tr onclick="location='<?php echo U('Home/MyClass/stuDetail',array('class_id' => $class['class_id'],'stu_id' => $stu['id']));?>'">
                    <td>
                        <?php if($i < 3): ?><img src="/mobile/images/integral/left1.png" alt="">
                        <?php else: ?>
                            <?php echo ($i + 1); endif; ?>
                    </td>
                    <td>
                        <img src="<?php echo imageDomain($stu['head_img']);?>" alt="">
                    </td>
                    <td><?php echo ($stu['name']); ?></td>
                    <td><?php echo ($stu['phone']); ?></td>
                    <td>
                        <?php echo ($stu['role']); ?>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
</html>
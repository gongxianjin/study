<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/library_list.css">
    <title>海尼曼绘本系列</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">图书馆</span>
    <!--右侧按钮-->
    <span class="header-btn">
            <a href="#"><i class="txh icon-share"></i></a>
    </span>

</div>
<div class="page">
    <div class="library-content">

        <?php if(is_array($bookList)): foreach($bookList as $key=>$item): if($key%3==0): ?><div class="library-box"><div class="library-box-content"><?php endif; ?>
            <div class="box-content-list <?php if($key%3==1): ?>list-center<?php endif; ?>">
                <a href="<?php echo U('library/book', array('book_id'=>$item['id']));?>">
                    <img src="<?php echo imageDomain($item['cover_img']);?>" style="width: 105px; height: 142px; border-radius: 5px;" alt="">
                    <p><?php echo ($item["name"]); ?></p>
                </a>
            </div>
            <?php if($key%3==2): ?></div></div><?php endif; endforeach; endif; ?>
        <?php if($key%3!=2): ?></div></div><?php endif; ?>

    </div>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/library.css">
    <title>图书馆</title>
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
    <div class="library-title">
        <div class="library-left">
            <img src="/mobile/images/header_img.png" alt="">
        </div>
        <div class="library-text">
            您的会员天数3天后到期
        </div>
        <div class="library-right">
            <a href="#">
                <img src="/mobile/images/right_bg.png" alt="">
                <div class="right_aside">
                    <i class="txh icon-qiandao"></i>
                    <p>签到</p>
                </div>
            </a>
            <a href="#">
                <img src="/mobile/images/right_bg.png" alt="">
                <div class="right_aside">
                    <i class="txh icon-shizhongtianjia"></i>
                    <p>续期</p>
                </div>
            </a>
        </div>
    </div>
    <div class="library-content">
        <div data-type='scroll' class="library-function">
            <div id="wrapper">
                <div id="scroller">
                    <?php $classifyList = D('BookClassify')->classifyList($platform_id); ?>
<?php if(is_array($classifyList)): foreach($classifyList as $key=>$item): ?><a class="function-list" href="<?php echo U('', array('classify_id'=>$item['id']));?>">
        <img src="<?php echo imageDomain($item['head_img']);?>" style="width: 52px; height: 52px; border-radius: 50%;" alt="">
        <p><?php echo ($item["name"]); ?></p>
    </a><?php endforeach; endif; ?>
                </div>
            </div>
        </div>
        <div class="line">
            <img src="/mobile/images/library/line.png" alt="">
        </div>
        <?php if(is_array($levelList)): foreach($levelList as $key=>$item): ?><div class="library-box">
                <div class="library-box-title">
                    <div class="box-title-left"><a href="#"><?php echo ($item["name"]); ?></a></div>
                    <div class="box-title-right">
                        <a href="<?php echo U('book_list', array('level_id'=>$item['id']));?>">更多<i class="txh icon-xiangzuo-copy"></i></a>
                    </div>
                </div>
                <div class="library-box-content">
                    <?php $bookList = D('Book')->where(array('level_id'=>$item['id']))->limit(3)->select(); ?>
                    <?php if(is_array($bookList)): $i = 0; $__LIST__ = $bookList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="box-content-list <?php if(($key) == "1"): ?>list-center<?php endif; ?> ">
                            <a href="<?php echo U('library/book', array('book_id'=>$item['id']));?>">
                                <img src="<?php echo imageDomain($item['cover_img']);?>" style="width: 105px; height: 142px; border-radius: 5px;" alt="">
                                <p><?php echo ($item["name"]); ?></p>
                            </a>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div><?php endforeach; endif; ?>
    </div>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/iscroll.js"></script>
<script>
    var myscroll;
    function loaded(){
        myscroll=new IScroll("#wrapper", { scrollX: true, scrollY: false, mouseWheel: true,click:true });
    }
    window.addEventListener("DOMContentLoaded",loaded,false);
</script>
</html>
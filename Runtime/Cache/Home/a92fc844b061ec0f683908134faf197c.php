<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/product_detail.css">
    <title>商品详情</title>
</head>
<body>
<div class="header">
    <div class="header-functionBar">
        <span class="header-back" onclick="window.location.href = '<?php echo U('shop/index');?>';">
            <i class="txh icon-xiangzuo"></i>
        </span>
        <span class="header-text">商品详情</span>
    </div>
    <style type="text/css">
        .header-topImg{position: relative;}
        .header-topImg img{position: absolute;}
    </style>
    <div class="header-topImg">
        <?php $_result=json_decode($img, true);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><img src="<?php echo imageDomain($img);?>"  alt=""><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php $_result=json_decode($img, true);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><div class="swiper-slide"><img src="<?php echo imageDomain($img);?>" alt=""></div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="header-tabbar">
        <div class="product-title"><?php echo ($name); ?></div>
        <div class="product-price">
            <span><?php echo ($score); ?></span>积分 +
            <span><?php echo sprintf("%.2f", $price);?></span>元
        </div>
        <div class="product-introduce">
            <div class="introduce-left">
                原价: <s>￥<?php echo sprintf("%.2f", $old_price);?></s>
            </div>
            <div class="introduce-right">
                <span><label>库存:</label><?php echo ($count); ?></span>
                <span><label>已售:</label><?php echo ($sold); ?></span>
            </div>
        </div>
    </div>
</div>
<div class="page">
    <div class="product-detail">
        <div class="product-detail-title">商品详情</div>
        <div class="product-detail-content">
            <?php echo ($content); ?>
        </div>
    </div>
</div>
<div class="footer">
    <a href="<?php echo U('shop/next', array('goods_id'=>$id));?>">立即兑换</a>
</div>
</body>
</html>
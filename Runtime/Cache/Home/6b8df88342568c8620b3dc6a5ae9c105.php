<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/intergral_shop.css">
    <title>积分商城</title>
</head>
<body>
<div class="header">
    <div class="header-functionBar">
        <span class="header-back" onclick="window.location.href = '/';">
            <i class="txh icon-xiangzuo"></i>
        </span>
        <span class="header-text">积分商城</span>
    </div>

    <div class="header-topImg">
        <img src="/mobile/images/buycar/topImg.png" alt="">
    </div>
    <div class="header-tabbar">
        <?php if(is_array($goodsTypeList)): foreach($goodsTypeList as $key=>$d): ?><a class="tabbar-common <?php echo isset($d['current'])?$d['current']:'';?>" href="<?php echo U('', array('goods_type_id'=>$d['id']));?>"><?php echo ($d["name"]); ?></a><?php endforeach; endif; ?>
    </div>
</div>
<div class="page">
    <div class="common-content">
        <?php if(is_array($showData)): foreach($showData as $key=>$item): if($key%2 == 0): ?><div class="common-content-list"><?php endif; ?>
            <div class="common-list-<?php echo ($key%2?'right':'left'); ?> list-common">
                <div class="common-list-img">
                    <a href="<?php echo U('shop/detail', array('goods_id'=>$item['id']));?>">
                        <img src="<?php echo imageDomain(current(json_decode($item['img'], true)));?>" alt="">
                    </a>
                </div>
                <div class="common-list-aside">
                    <a href="<?php echo U('shop/detail', array('goods_id'=>$item['id']));?>" class="list-aside-title"><?php echo ($item["name"]); ?> </a>
                    <div class="list-aside-price">
                        <span class="price-intergral"><?php echo ($item["score"]); ?></span>积分 +
                        <span class="price-rmb"><?php echo ($item["price"]); ?></span>元
                    </div>
                    <div class="list-introduce">
                        <div class="introduce-left"><label>原价:</label><s>￥<?php echo ($item["old_price"]); ?></s></div>
                        <div class="introduce-right">
                            <span> <label>库存:</label><?php echo ($item["count"]); ?></span>
                            <span><label>已售:</label><?php echo ($item["sold"]); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($key%2 == 1): ?></div><?php endif; endforeach; endif; ?>
    <?php if($key%2 == 0): ?></div><?php endif; ?>
</div>
</div>

</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>
<script>
    $()
    $(function(){
        $(".header-tabbar").on("click",".tabbar-common",function(){
            if(!$(this).hasClass("current")){
                $(this).addClass("current").siblings().removeClass("current")
            }
            $($(".common-content")[$(this).index()]).css("display","block").siblings().css("display","none")
        })
    })
</script>

</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/product_exchange.css">
    <link rel="stylesheet" href="/mobile/style/product_exchange_next.css">
    <title>商品兑换</title>
</head>
<body>
<div class="header">
    <div class="header-functionBar">
        <span class="header-back" onclick="window.location.href = '<?php echo U('shop/detail', array('goods_id'=>I('get.goods_id', 0, 'intval')));?>';">
            <i class="txh icon-xiangzuo"></i>
        </span>
        <span class="header-text">商品兑换</span>
    </span>
    </div>
    <div class="header-tabbar">
        <?php if(isset($user_id)): ?><a href="<?php echo U('address/index');?>" class="person-infor" style="display:flex;">
                <div class="infor-left">
                    <div class="person-infor-top">
                        <i class="txh icon-geren-80"></i>
                        <span class="username"><?php echo ($nickname); ?></span>
                        <span class="phone-num"><?php echo ($phone); ?></span>
                    </div>
                    <div class="person-infor-down"><?php echo ($address); ?></div>
                </div>
                <div class="infor-right"><i class="txh icon-xiangzuo-copy"></i></div>
            </a>
            <input type="hidden" name="address_id" value="<?php echo ($address_id); ?>" />
        <?php else: ?>
            <div class="add-address">
                <a href="<?php echo U('address/index');?>"><i class="txh icon-icon02"></i>添加新地址</a>
            </div><?php endif; ?>
    </div>
</div>
<div class="page">
    <div class="content-box">
        <div class="product-list">
            <div class="product-list-left"><img src="<?php echo imageDomain(current(json_decode($img, true)));?>" alt=""></div>
            <div class="product-list-right">
                <div class="list-product-title"><?php echo ($name); ?></div>
                <div class="list-product-price">
                    <span class="intergral-num"><?php echo ($score); ?></span>积分 +
                    <span class="rmb-num"><?php echo sprintf("%.2f", $price);?></span>元
                </div>
                <div class="list-product-num">
                    <label>数量:</label>
                    <span class="amount-num">1</span>
                </div>
            </div>
        </div>
        <div class="product-choice-num common-list">
            <div class="choice-num-left common-list-left">购买数量</div>
            <div class="choice-num-right common-list-right">
                <div class="cart-amount">
                    <span class="reduce-num">-</span>
                    <input type="number" class="num-amounts" id="goods_count" value="1">
                    <span class="add-num">+</span>
                </div>

            </div>
        </div>
        <!--<div class="product-choice-color common-list">-->
            <!--<div class="common-list-left">选择颜色</div>-->
            <!--<div class="common-list-right">-->
                <!--<button>红色</button>-->
                <!--<button>蓝色</button>-->
                <!--<button class="current">粉色</button>-->
            <!--</div>-->
        <!--</div>-->
        <div class="product-choice-color common-list">
            <div class="common-list-left">商品价格</div>
            <div class="common-list-right pay-price">
                <span class="pay-intergral"><?php echo ($score); ?></span>积分 +
                <span class="pay-rmb"><?php echo sprintf("%.2f", $price);?></span>元
            </div>

        </div>
    </div>

</div>

<?php $urls = urldecode(U('order/goods', array( 'address_id' => $address_id, 'count' => '${count}', 'goods_id' => I('get.goods_id', 0, 'intval'), ))); ?>
<div class="footer">
    <a href="#" onclick="ck.pay();">立即支付</a>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>
<script>

    (function(_){
        _.pay = function()
        {
            var count = $('#goods_count').val();
            window.location.href = decodeURI(`<?php echo ($urls); ?>`);
        };
    })(ck={});

    $(".reduce-num").on('click',function(){
        var count = +$(this).next().val() <=1 ? 1 : $(this).next().val() - 1;
        $(this).next().val(count);
        payPrice();
    });

    $(".num-amounts").bind('input propertychange',function (){
        payPrice();
    });

    $(".add-num").on("click",function(){
        var count = eval($(this).prev().val())+1;
        $(this).prev().val(count);
        payPrice();
    });

    var singlePrice = eval($(".rmb-num").html());
    var singleIntergral = parseInt($(".intergral-num").html());
    function payPrice()
    {
        var totalPrice = 0;
        var totalIntergral = 0;
        var productNum = parseInt($(".num-amounts").val());
        totalPrice = productNum * singlePrice;
        totalIntergral = productNum * singleIntergral;
        $(".pay-intergral").html(totalIntergral);
        $(".pay-rmb").html(totalPrice);
        $(".amount-num").html(productNum );
    }

    $(".common-list-right").on("click","button",function()
    {
        if(!$(this).hasClass("current"))
        {
            $(this).addClass("current").siblings().removeClass("current")
        }
    });
</script>
</html>
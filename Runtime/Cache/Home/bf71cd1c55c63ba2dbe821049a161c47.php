<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript">
    function onBridgeReady(){
        console.log(1);
        WeixinJSBridge.invoke('getBrandWCPayRequest',
                {
                    "appId":"<?php echo ($appId); ?>",     //公众号名称，由商户传入
                    "timeStamp":"<?php echo ($timeStamp); ?>",         //时间戳，自1970年以来的秒数
                    "nonceStr":"<?php echo ($nonceStr); ?>", //随机串
                    "package":"<?php echo ($package); ?>",
                    "signType":"MD5",         //微信签名方式：
                    "paySign":"<?php echo ($paySign); ?>" //微信签名
                },
                function(res)
                {
                    if(res.err_msg == "get_brand_wcpay_request:ok")
                    {
                        window.history.back();
                    }
                    else if(res.err_msg == "get_brand_wcpay_request:cancel")
                    {
                        window.history.back();
                    }
                    else if(res.err_msg == "get_brand_wcpay_request:fail")
                    {
                        window.history.back();
                    }
                }
        );
    }
    if (typeof WeixinJSBridge == "undefined")
    {
        if( document.addEventListener )
        {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        }
        else if (document.attachEvent)
        {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    }
    else
    {
        onBridgeReady();
    }
</script>
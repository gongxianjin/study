<?php

namespace Home\Controller;

class OrderController extends Base
{

    public function goods()
    {
        $goods_id = I('goods_id', 0 , 'intval');
        if( ! $goods_id ){
            ajaxReturn('缺少商品信息');
        }

        $address_id = I('address_id', 0 , 'intval');
        if( ! $address_id ){
            ajaxReturn('请选择收货地址');
        }

        $goodsInfo = D('ScoreShop')->findFirst($goods_id);
        if( ! isset($goodsInfo['id']) ){
            ajaxReturn('商品不存在');
        }

        $addressInfo = D('UserAddress')->findFirst($address_id);
        if( ! isset($addressInfo['id']) ){
            ajaxReturn('缺少收货地址信息');
        }

        $count = I('count', 1, 'intval');
        $score = $goodsInfo['score'] * $count;
        $fundsInfo = D('UserFunds')->findFirst($this->user_id);
        if( ! isset($fundsInfo['score']) || $fundsInfo['score'] < $score){
            ajaxReturn('你的兑换积分不足');
        }

        $goods_id = $goodsInfo['id'];
        $price = $goodsInfo['price'] * $count;
        $s_address = $addressInfo['address'];
        $s_nickname = $addressInfo['nickname'];
        $s_phone = $addressInfo['phone'];
        $goods_name = $goodsInfo['name'];
        $s_url = $goodsInfo['url'];

        $orderModel = new \Home\Model\ScoreOrderModel();
        $trade_no = $orderModel->createTrade();

        $orderModel->startTrans();
        if( ! $orderModel->addTrade($trade_no, $price, $this->user_id, $goods_id,
            $s_address, $s_nickname, $s_phone, $goods_name, $count, $score, $s_url) )
        {
            $orderModel->rollback();
            ajaxReturn('订单创建失败');
        }

        if( ! $price )
        {
            $orderModel->commit();

            $tradeModel = new \Home\Model\UserScoreDetailModel();
            if( ! $tradeModel->setScoreDetail($this->user_id, 1,
                $score, '积分商城', $goods_id, '积分商城，商品兑换抵扣'))
            {
                $tradeModel->rollback();
                ajaxReturn('兑换失败', 0);
            }

            $orderModel->setStatus($trade_no, $trade_no, 1);
            ajaxReturn('兑换成功', 0);
        }


        //微信统一下单
        $wxModel = new \Weixin\Api\Pay();
        $notify_url = "http://" . $_SERVER['HTTP_HOST'] . "/weixin/callback/goods";
        $payData = $wxModel->getCode($trade_no, $price, $notify_url,  "童学惠-积分商城兑换"); 
        if($payData === false)
        {
            $orderModel->rollback();
            ajaxReturn('微信下单失败');
        }
        $orderModel->commit();
        $this->assign($payData);
        $this->display('weixin/pay');
    }



    // 保证金
    public function caution()
    {
        $grade_id = I('grade_id', 0, 'intval');
        if( ! $grade_id ){
            ajaxReturn('缺少参数');
        }
        $gradeInfo = D('Grade')->findFirst($grade_id);
        if( ! isset($gradeInfo['price']) ){
            ajaxReturn('缺少参数');
        }
        if( $gradeInfo['platform_id'] != $this->platform_id ){
            ajaxReturn('缺少参数');
        }
        $price = $gradeInfo['price'];

        // 生成订单
        $orderModel = new \Home\Model\OrderModel();
        $trade_no = $orderModel->createTrade();

        //微信统一下单
        $wxModel = new \Weixin\Api\Pay();
        $notify_url = "http://" . $_SERVER['HTTP_HOST'] . "/weixin/callback/caution";
        $payData = $wxModel->getCode($trade_no, $price, $notify_url,  "童学惠-保证金充值");
        if($payData === false){
            ajaxReturn('微信下单失败');
        }
//        if( ! $orderModel->addTrade($trade_no, $price, $this->user_id, $this->platform_id, $grade_id) ){
//            ajaxReturn('订单创建失败');
//        }
//        $this->assign($payData);
//        $this->display('weixin/pay');

        $jsApiParameters = json_encode($payData);
        $shtml = <<<EOT
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			{$jsApiParameters},
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+'----'+res.err_desc+'-----'+res.err_msg);
				switch(res.err_msg){
					case 'get_brand_wcpay_request:cancel':
						alert('cancel')
						document.getElementById('wxchat').style.display = 'none';
						document.getElementById('wxchat_f_msg').innerHTML = '您已取消支付，可到订单中心再次发起支付';
						document.getElementById('wxchat_fail').style.display = 'block';

					break;

					case 'get_brand_wcpay_request:fail':
						document.getElementById('wxchat').style.display = 'none';
						//document.getElementById('wxchat_f_msg').innerHTML = '支付失败，可到订单中心再次发起支付';
						document.getElementById('wxchat_fail').style.display = 'block';
					break;

					case 'get_brand_wcpay_request:ok':
						document.getElementById('wxchat').style.display = 'none';
						document.getElementById('wxchat_ok').style.display = 'none';

					default:
						//alert(window.location.href)
						//alert(res.err_msg);

					break;
				}


				/*var str = '';
				for(var i in res){
					str += i+'='+res[i]+'&';
				}
				alert(str)*/
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}

	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress);
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			//callpay();
		}
	};
	callpay();
	</script>
</head>
<body>

<div id="wxchat" style="text-align:center;margin-top:20px; display:none;">
    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">0.1元</span></b></font><br/><br/>
	<div align="center">
		<button style="width:96%; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
	</div>

</div>

<div id="wxchat_fail" style="text-align:center;margin-top:100px;display:none;">
	<font color="#9ACD32"><b id="wxchat_f_msg">支付失败</b></font><br><br><br><br>
</div>

<div id="wxchat_ok" style="text-align:center;margin-top:100px;display:none;">
	<font color="#f00"><b>支付成功</b></font><br><br><br><br>
</div>
</body>
</html>
EOT;
        exit($shtml);

    }
}
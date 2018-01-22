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
        if( ! $orderModel->addTrade($trade_no, $price, $this->user_id, $this->platform_id, $grade_id) ){
            ajaxReturn('订单创建失败');
        }
        $this->assign($payData);
        $this->display('weixin/pay');
    }
}
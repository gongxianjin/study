<?php

namespace Weixin\Controller;
use Think\Controller;

class CallbackController extends Controller
{
    public function goods()
    {
        $wxModel = new \Weixin\Api\Pay();
        $param = $wxModel->common();

        // 查询订单是否存在
        $trade_no = $param['out_trade_no'];
        $tradeModel = new \Home\Model\ScoreOrderModel();
        $tradeInfo = $tradeModel->findFirst($trade_no);
        if( ! isset($tradeInfo['user_id']) )
        {
            $wxModel->returnMsg('订单不存在', true);
        }

        // 订单状态
        if(0 != $tradeInfo['status'])
        {
            $wxModel->returnMsg('订单状态异常');
        }

        $tradeModel->startTrans();
        if( ! $tradeModel->setStatus($trade_no, $param['transaction_id'], 1))
        {
            $tradeModel->rollback();
            $wxModel->returnMsg('订单状态修改失败');
        }

        $tradeModel = new \Home\Model\UserScoreDetailModel();
        if( ! $tradeModel->setScoreDetail($tradeInfo['user_id'], 1,
            $tradeInfo['score'], '积分商城', $tradeInfo['id'], '积分商城，商品兑换抵扣'))
        {
            $tradeModel->rollback();
            $wxModel->returnMsg('订单记录失败');
        }
        $tradeModel->commit();
        $wxModel->returnMsg('OK', true);
    }

    public function caution()
    {
        $wxModel = new \Weixin\Api\Pay();
        $param = $wxModel->common();
        // 查询订单是否存在
        $trade_no = $param['out_trade_no'];
        $tradeModel = new \Home\Model\OrderModel();
        $tradeInfo = $tradeModel->findFirst($trade_no);
        if( ! isset($tradeInfo['user_id']) )
        {
            $wxModel->returnMsg('订单不存在', true);
        }

        // 订单金额
        if(($param['total_fee']/100) !=  $tradeInfo['price'])
        {
            $wxModel->returnMsg('支付金额与订单金额不一致', true);
        }

        // 订单状态
        if(0 != $tradeInfo['status'])
        {
            $wxModel->returnMsg('订单状态异常');
        }

        $tradeModel->startTrans();
        if( ! $tradeModel->setStatus($trade_no, $param['transaction_id'], 1))
        {
            $tradeModel->rollback();
            $wxModel->returnMsg('订单状态修改失败');
        }
        $CurriculumModel = new \Home\Model\CurriculumModel();
        if( ! $CurriculumModel->setAdd($tradeInfo['platform_id'], $tradeInfo['user_id'], $tradeInfo['grade_id']))
        {
            $tradeModel->rollback();
            $wxModel->returnMsg('增加失败');
        }
        $EnlistsModel = new \Home\Model\EnlistsModel();
        if( ! $EnlistsModel->setList(0,$tradeInfo['platform_id'], $tradeInfo['user_id'], $tradeInfo['grade_id'],1))
        {
            $tradeModel->rollback();
            $wxModel->returnMsg('增加失败');
        }
        $tradeModel->commit();
        $wxModel->returnMsg('OK', true);
    }
}
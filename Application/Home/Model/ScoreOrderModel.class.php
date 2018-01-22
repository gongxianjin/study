<?php

namespace Home\Model;
use Think\Model;

class ScoreOrderModel extends Model
{
    public function createTrade()
    {
        return 'S' . date("YmdHis") . rand(10000, 99999);
    }

    public function setStatus($trade_no, $transaction_id, $status)
    {
        return $this->where(array('trade_no' => $trade_no))->save(array(
            'out_trade_no' => $transaction_id,
            'pay_time' => time(),
            'status' => $status,
        ));
    }

    public function findFirst($trade_no)
    {
        return $this->where(array('trade_no'=>$trade_no))->find();
    }

    public function addTrade($trade_no, $price, $user_id, $goods_id, $s_address, $s_nickname, $s_phone,
                             $goods_name, $count, $score, $s_url = '', $code = '')
    {
        return $this->add(array(
            'trade_no' => $trade_no,
            'price' => $price,
            'user_id' => $user_id,
            'goods_id' => $goods_id,
            's_address' => $s_address,
            's_url' => $s_url,
            's_nickname' => $s_nickname,
            's_phone' => $s_phone,
            'goods_name' => $goods_name,
            'count' => $count,
            'score' => $score,
            'code' => $code,
            'create_time' => time(),
        ));
    }
}
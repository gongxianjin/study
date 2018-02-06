<?php

namespace Home\Model;
use Think\Model;

class OrderModel extends Model
{
    public function createTrade()
    {
        return 'T' . date("YmdHis") . rand(10000, 99999);
    }

    public function addTrade($trade_no, $price, $user_id, $platform_id, $grade_id)
    {
        return $this->add(array(
            'trade_no' => $trade_no,
            'price' => $price,
            'user_id' => $user_id,
            'create_time' => time(),
            'platform_id' => $platform_id,
            'grade_id' => $grade_id,
        ));
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
        return $this->where(array('trade_no' => $trade_no))->find();
    }

    public function getOrder($user_id,$class_id){
        $query = $this->where('user_id = ' . $user_id . ' and grade_id = ' . $class_id)->find();
        return $query;
    }
}
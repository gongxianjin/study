<?php

namespace Home\Model;
use Think\Model;

class UserFundsModel extends Model
{
    public function getMoney($user_id)
    {
        $result = $this->findFirst($user_id);
        if( ! isset($result['money']) ){
            return sprintf("%.2f", 0);
        }
        return sprintf("%.2f", $result['money']-$result['frozen_money']);
    }

    public function getScore($user_id)
    {
        return (int)$this->where(array('user_id'=>$user_id))->getField('score');
    }

    public function findFirst($user_id)
    {
        return $this->where(array('user_id'=>$user_id))->find();
    }

    public function addFunds($user_id)
    {
        return $this->add(array('user_id'=>$user_id));
    }
}
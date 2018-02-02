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

    //getFundsDetail
    public function getFundsDetail($user_id){
        $res = array();
        $res['id'] = $user_id;
        $res['name'] = M('User')->where('id = ' . $user_id)->getField('nickname');
        //可用积分
        $res['score'] = $this->getScore($user_id);

        $tmp = M('UserScoreDetail')->where('user_id = ' . $user_id)->select();
        $scoreList = array();
        $usedScore = 0;
        foreach($tmp as $one){
            $score = array(
                    'score' => ((int)$one['type'] == 0 ? "+" : "-") . $one['score'],
                    'source' => $one['source'],
                    'value' => $one['value'],
                    'time' => date("Y-m-d",(int)$one['time'])
                );
            array_push($scoreList, $score);
            if ((int)$one['type'] == 1) {
                $usedScore += $one['score'];                
            }            
        }
        $res['usedScore'] = $usedScore;
        $res['scoreList'] = $scoreList;

        return $res;
    }
}
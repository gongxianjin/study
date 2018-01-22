<?php

namespace Home\Model;
use Think\Model;

class UserScoreDetailModel extends Model
{
    public function detailList($user_id, $type = 0)
    {
        return $this->where(array('user_id'=>$user_id))->select();
//        return $this->where(array('user_id'=>$user_id, 'type'=>$type))->select();
    }


    public function setScoreDetail($user_id, $type, $score, $source, $value, $content)
    {
        return $this->add(array(
            'user_id' => $user_id,
            'type' => $type,
            'score' => $score,
            'source' => $source,
            'value' => $value,
            'content' => $content,
            'time' => time(),
        ));
    }


}
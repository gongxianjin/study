<?php

namespace Home\Model;
use Think\Model;

class ClassifyLevelModel extends Model
{
    public function levelList($classify_id, $platform_id=0)
    {
        if( ! $classify_id ){
            return array(1);
        }
        if( ! $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        $where['classify_id'] = $classify_id;
        return $this->where($where)->select();
    }
}
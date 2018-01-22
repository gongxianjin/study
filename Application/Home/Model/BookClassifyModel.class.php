<?php

namespace Home\Model;
use Think\Model;

class BookClassifyModel extends Model
{
    public function classifyList($platform_id = false)
    {
        $where = array();
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        return $this->where($where)->field('id,name,head_img')->select();
    }
}
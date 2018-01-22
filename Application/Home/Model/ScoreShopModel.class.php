<?php

namespace Home\Model;
use Think\Model;

class ScoreShopModel extends Model
{
    public function scoreShopList($platform_id, $type_id)
    {
        $where = array();
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $type_id ){
            $where['type_id'] = $type_id;
        }
        return $this->where($where)->select();
    }
    public function findFirst($goods_id)
    {
        return $this->where(array('id' => $goods_id))->find();
    }
}
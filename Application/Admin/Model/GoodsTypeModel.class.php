<?php

namespace Admin\Model;
use Think\Model;

class GoodsTypeModel extends Model
{
    public function goodsTypeList($platform_id, $name)
    {
        $where = array();
        if(  $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $name ){
            $where['name'] = array('like', "%{$name}%");
        }
        $page = new \Think\Page($this->where($where)->count());
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)->limit($page->firstRow)->select(),
        );
    }

    public function findByName($platform_id, $type_name)
    {
        return $this->where(array(
            'platform_id' => $platform_id,
            'name' => $type_name,
        ))->find();
    }


    public function findFirst($platform_id, $type_id)
    {
        return $this->where(array(
            'platform_id' => $platform_id,
            'id' => $type_id,
        ))->find();
    }

    public function setGoodsType($platform_id, $goods_type_id, $type_name, $whether)
    {
        $param['name'] = $type_name;
        $param['whether'] = $whether;
        if( $goods_type_id ){
            return $this->where(array('id'=>$goods_type_id))->save($param);
        }
        $param['platform_id'] = $platform_id;
        $param['time'] = time();
        return $this->add($param);
    }
}
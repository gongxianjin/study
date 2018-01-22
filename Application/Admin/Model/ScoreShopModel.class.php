<?php

namespace Admin\Model;
use Think\Model;
use Think\Page;

class ScoreShopModel extends Model
{
    public function setGoods($platform_id, $goods_id, $goods_name, $goods_type_id, $goods_old_price
        ,$goods_price, $goods_score, $goods_count, $goods_sold, $goods_url, $goods_images, $content)
    {
        $param['name'] = $goods_name;
        $param['type_id'] = $goods_type_id;
        $param['old_price'] = $goods_old_price;
        $param['price'] = $goods_price;
        $param['score'] = $goods_score;
        $param['count'] = $goods_count;
        $param['sold'] = $goods_sold;
        $param['url'] = $goods_url;
        $param['img'] = json_encode($goods_images);
        $param['content'] = $content;
        if( $goods_id ){
            return $this->where(array('id'=>$goods_id))->save($param);
        }

        $param['platform_id'] = $platform_id;
        $param['time'] = time();
        return $this->add($param);
    }


    public function findFirst($platform_id, $goods_id)
    {
        $where = array();
        if($platform_id){
            $where['platform_id'] = $platform_id;
        }
        $where['id'] = $goods_id;
        if( ! $where ){
            return array();
        }
        return $this->where($where)->find();
    }

    public function scoreList($platform_id, $name)
    {
        $where = array();
        if(  $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $name ){
            $where['name'] = array('like', "%{$name}%");
        }
        $page = new Page($this->where($where)->count());
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)->limit($page->firstRow)->select(),
        );
    }

}
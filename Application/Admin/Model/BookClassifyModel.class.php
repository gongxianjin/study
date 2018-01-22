<?php

namespace Admin\Model;
use Think\Model;
use Think\Page;

class BookClassifyModel extends Model
{
    public function setClassify($platform_id, $classify_id, $name, $classify_img)
    {
        $param['name'] = $name;
        $param['head_img'] = $classify_img;
        if( $classify_id ){
            return $this->where(array('id'=>$classify_id))->save($param);
        }
        $param['time'] = time();
        $param['platform_id'] = $platform_id;
        return $this->add($param);
    }

    public function checkClassifyName($platform_id, $classify_name)
    {
        if ( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if ( $classify_name ){
            $where['name'] = $classify_name;
        }
        return $this->where(array('name'=>$classify_name))->find();
    }

    public function getClassifyList($platform_id, $classify_name)
    {
        $where = array();
        if ( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if ( $classify_name ){
            $where['name'] = array('like', "%{$classify_name}%");
        }
        $page = new Page($this->where($where)->count(), C('ADMIN_LIMIT_INIT'));
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)->limit($page->firstRow, C('ADMIN_LIMIT_INIT'))->select()
        );
    }
}
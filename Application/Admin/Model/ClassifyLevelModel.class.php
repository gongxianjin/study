<?php

namespace Admin\Model;

use Think\Model;

class ClassifyLevelModel extends Model
{
    public function setLevel($platform_id, $level_id, $classify_id, $name)
    {
        $param['name'] = $name;
        $param['classify_id'] = $classify_id;
        $param['head_img'] = '';
        if( $level_id ){
            return $this->where(array('id'=>$level_id))->save($param);
        }
        $param['platform_id'] = $platform_id;
        $param['time'] = time();
        return $this->add($param);
    }

    public function findFirst($level_id)
    {
        return $this->where(array('id'=>$level_id))->find();
    }

    public function getLevelList($platform_id, $level_name, $classify_id)
    {
        $where = array();
        if ( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if ( $classify_id ){
            $where['classify_id'] = $classify_id;
        }
        if ( $level_name ){
            $where['name'] = array('like', "%{$level_name}%");
        }
        $page = new \Think\Page($this->where($where)->count(), C('ADMIN_LIMIT_INIT'));
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)->limit($page->firstRow, C('ADMIN_LIMIT_INIT'))->select()
        );
    }
}
<?php

namespace Admin\Model;
use Think\Model;

class PlatformModel extends Model
{
    public function findFirst($platform_id)
    {
        return $this->where(array('platform_id'=>$platform_id))->find();
    }

    public function getPlatformList()
    {
        $where = array();
        $page = new \Think\Page($this->where($where)->count(), C('ADMIN_LIMIT_INIT'));
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)->limit($page->firstRow, C('ADMIN_LIMIT_INIT'))->select()
        );
    }
}
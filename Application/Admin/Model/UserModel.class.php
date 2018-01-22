<?php

namespace Admin\Model;
use Think\Model;

class UserModel extends Model
{
    public function userList($platform_id, $name)
    {
        $where = array();
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $name ){
            $where['`user`.`nickname`'] = array("like", "%{$name}%");
        }
        $page = new \Think\Page($this->where($where), C('ADMIN_LIMIT_INIT'));
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)
                ->join("LEFT JOIN `platform` ON `platform`.`id`=`user`.`platform_id` ")
                ->field("`user`.*,`platform`.`platform_name`")
                ->limit($page->firstRow, C('ADMIN_LIMIT_INIT'))->select()
        );
    }
}
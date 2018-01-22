<?php

namespace Admin\Model;
use Think\Model;
use Think\Page;

class ClassesModel extends Model
{
    public function getClassesList($platform_id, $user_id=0)
    {
        $where = array();
        if( $platform_id ){
            $where['`classes`.`platform_id`'] = $platform_id;
        }
        if( $platform_id ){
            $where['`classes`.`user_id`'] = $user_id;
        }
        $page = new Page($this->where($where)->count(), C('ADMIN_LIMIT_INIT'));
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)->limit($page->firstRow, C('ADMIN_LIMIT_INIT'))
                ->join("LEFT JOIN `user` ON `user`.`id`=`classes`.`user_id`")
                ->join("LEFT JOIN `platform` ON `platform`.`id`=`classes`.`platform_id`")
                ->field("`classes`.*,`platform`.`platform_name`,`user`.`nickname`")
                ->select()
        );
    }
}
<?php

namespace Home\Model;
use Think\Model;
use Think\Page;

class ForumModel extends Model
{
    public function addForum($platform_id, $user_id, $content, $img)
    {
        return $this->add(array(
            'platform_id' => $platform_id,
            'user_id' => $user_id,
            'content' => $content,
            'img' => json_encode($img),
            'time' => time(),
        ));
    }

    public function bbsList($platform_id = 0)
    {
        $where = array();

        if( $platform_id ){
            $where['`forum`.`platform_id`'] = $platform_id;
        }
        $page = new Page($this->where($where)->count());
        return $this->where($where)
            ->join("LEFT JOIN `user` ON `user`.`id` = `forum`.`user_id`")
            ->limit($page->firstRow, 20 )->field('`forum`.*,`user`.`nickname`,`user`.`head_img`')->select();
    }
}
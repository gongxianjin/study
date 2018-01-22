<?php

namespace Admin\Model;

use Think\Model;

class BookModel extends Model
{
    public function findFirst($platform_id, $book_id)
    {
        return $this->where(array('id'=> $book_id, 'platform_id'=>$platform_id))->find();
    }

    public function checkBookName($platform_id, $classify_id, $level_id, $user_id, $book_name)
    {
        return $this->where(array(
            'platform_id'=>$platform_id,
            'classify_id' => $classify_id,
            'level_id' => $level_id,
            'user_id' => $user_id,
            'name' => $book_name,
        ))->find();
    }

    public function setBook($platform_id, $book_id,
                            $book_name, $cover_img, $classify_id, $level_id, $user_id, $type = 0)
    {
        $param['name'] = $book_name;
        $param['cover_img'] = end(explode('__', $cover_img));
        $param['classify_id'] = $classify_id;
        $param['level_id'] = $level_id;
        $param['type'] = $type;
        if( ! $book_id )
        {
            $param['user_id'] = $user_id;
            $param['platform_id'] = $platform_id;
            $param['time'] = time();
            return $this->add($param);
        }
        if($this->where(array('id'=>$book_id))->save($param) === false){
            return false;
        }
        return $book_id;
    }

    public function getBookList($platform_id, $book_name)
    {
        $where = array();
        if( $platform_id ){
            $where['`book`.`platform_id`'] = $platform_id;
        }

        if( $book_name ){
            $where['`book`.`name`'] = array('like', "%{$book_name}%");
        }

        $page = new  \Think\Page($this->where($where)->count(), C('ADMIN_LIMIT_INIT'));
        return array(
            'page' => $page->show(),
            'showData' => $this->where($where)
                ->join("LEFT JOIN `book_classify` ON `book_classify`.`id` = `book`.`classify_id`")
                ->join("LEFT JOIN `classify_level` ON `classify_level`.`id` = `book`.`level_id`")
                ->field("`book`.*,`book_classify`.`name` as `classify_name`,`classify_level`.`name` as `level_name`")
                ->limit($page->firstRow, C('ADMIN_LIMIT_INIT'))->select()
        );
    }
}




















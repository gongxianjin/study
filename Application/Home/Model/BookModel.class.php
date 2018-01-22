<?php

namespace Home\Model;
use Think\Model;

class BookModel extends Model
{
    public function bookList($platform_id=false)
    {
        $where = array();
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        return $this->where($where)->select();
    }

    public function findFirst($book_id = false)
    {
        return $this->where(array('id' => $book_id))->find();
    }
}
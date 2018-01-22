<?php

namespace Admin\Model;

use Think\Model;

class BookResModel extends Model
{
    public function resDelete($book_id)
    {
        return $this->where(array('book_id'=>$book_id))->delete();
    }

    public function addRes($params)
    {
        return $this->addAll($params);
    }

    public function getResList($book_id)
    {
        return $this->where(array('book_id'=>$book_id))->select();
    }
}
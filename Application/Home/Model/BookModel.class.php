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

    public function getBooks($teacher_id){
        if (isset($teacher_id)) {
            $res = array();
            $oneBook = array();
            $query = M("Book")->where("user_id = " . (int)$teacher_id)->order("id asc")->select();
            foreach($query as $one){
                foreach($one as $key => $value){
                    $oneBook[$key] = $one[$key];
                }
                $oneBook['cover_img'] = imageDomain($oneBook['cover_img'],"/mobile/images/activity/activity_fengmian.png");
                if ((int)$oneBook['status'] == 1) {
                   $oneBook['status'] = "已发布";
                   $oneBook['s_html'] = "public";
                }else{
                    $oneBook['status'] = "未发布";
                    $oneBook['s_html'] = "";
                }
                array_push($res, $oneBook);
                $oneBook = array();
            }
        }
        return $res;
    }
}
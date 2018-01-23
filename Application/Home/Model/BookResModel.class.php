<?php

namespace Home\Model;
use Think\Model;

class BookResModel extends Model{

	public function getTextBooks($teacher_id){
		if (isset($teacher_id)) {
			$model = M('Book');
			//所有图书
			$books = $model->field("id,name")->where("user_id = " . (int)$teacher_id)->order("id asc")->select();

			$res = array();
			$oneBook = array();
			foreach($books as $book){
				$temp = M('BookRes')->where('book_id = ' . (int)$book['id'])->order("id asc")->select();
				foreach($temp as $one){
					$oneBook['book_name'] = $book['name'];
					foreach($one as $key => $value){
						$oneBook[$key] = $one[$key];
					}
					array_push($res, $oneBook);
					$oneBook = array();
				}
			}

			return $res;
		}else{
			$this->error("非法操作");
		}
	}
}
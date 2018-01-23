<?php
namespace Home\Controller;

/*
* 晨曦
* 教师端 - 创建作业
*/
class CreateBookController extends Base{

	public function index(){
		$this->display();
	}

	//获取课文列表
	public function getTextBooks(){
		if ($this->user_type == 1) {
			//教师
			$teacher_id = $this->user_id;
			$res = D('BookRes')->getTextBooks($teacher_id);
			// echo json_encode($res);
			$this->ajaxReturn($res);

		}else{
			$this->error("权限不足");
		}

	}

	//获取课本列表
	public function getBooks(){
		if ($this->user_type == 1) {
			//教师
			$teacher_id = $this->user_id;
			$res = D('Book')->getBooks($teacher_id);
			// echo json_encode($res);
			$this->ajaxReturn($res);
		}else{
			$this->error("权限不足");
		}
	}
}

?>
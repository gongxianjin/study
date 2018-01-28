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

	//合成预览
	public function previewBook(){
		echo "合成预览";
	}

	//保存课本
	public function saveBook(){
		echo "保存课本";
	}

	//保存课文
	public function saveTextBook(){
		echo "保存课文";
	}
	//发布课本
	public function publishBook(){
		echo "发布课本";
	}


	//自制课文
	public function createBooktext(){
		$post = I('post.');
		$file = $_FILES['file1'];
		$upload = new \Common\Model\Upload();
		$filename = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
		echo $filename;
		$upRes = $upload->upload($filename,$file['tmp_name']);
		echo "result" . $upRes;
	}

	public function upload(){

	}
}

?>
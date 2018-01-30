<?php
namespace Home\Controller;

/*
* 晨曦
* 教师端 - 我的班级
*/

class MyClassController extends Base{

	public function index(){
		$classes = M('Classes');
		$query = $classes->where('user_id = ' . $this->user_id)->order('class_id asc')->select();
		$this->assign('classes',$query);
		$this->display();
	}

	//班级详情
	public function classDetail(){
		$class_id = $_GET['class_id'];

		//班级信息
		$c = M('Classes')->where("class_id = " . $class_id . " and user_id = " . $this->user_id)->find();
		if (!$c) {
			ajaxReturn("非法请求");
		}

		//成员信息
		
		$this->assign('class',$c);
		$this->display();
	}

	//添加班级
	public function addClass(){
		$this->display();
	}

	public function createClass(){
		if (!IS_POST) {
			ajaxReturn("非法请求");
		}

		$post = I('post.');

		$c = array(
				'user_id' => $this->user_id,
				'platform_id' => $this->platform_id,
				'class_name' => $post['class_name'],
				'count' => 0,
				'time' => time(),
				'status' => 1,
				'image' => $post['head_img'],
				'description' => substr($post['class_desc'], 0, 40)
			);
		$query = M('Classes')->add($c);
		if ($query) {
			ajaxReturn("添加班级成功");
		}else{
			ajaxReturn("添加班级失败");
		}
	}

	//编辑班级
	public function editClass(){
		$class_id = $_GET['class_id'];
		$query = M('Classes')->where('class_id = ' . $class_id . ' and user_id = ' . $this->user_id)->find();
		if (!$query) {
			$this->error('非法请求');
		}
		$this->assign('class',$query);
		$this->display();
	}

	public function saveClass(){
		if (!IS_POST) {
			ajaxReturn("非法请求");
		}

		$post = I('post.');

		$c = array(
				'user_id' => $this->user_id,
				'platform_id' => $this->platform_id,
				'class_name' => $post['class_name'],
				'count' => 0,
				'time' => time(),
				'status' => 1,
				'image' => $post['head_img'],
				'description' => substr($post['class_desc'], 0, 40)
			);
		$query = M('Classes')->where('class_id = ' . $post['class_id'] . " and user_id = " . $this->user_id)->save($c);
		if ($query) {
			ajaxReturn("保存成功");
		}else{
			ajaxReturn("保存失败");
		}
	}
	//删除班级
	public function delClass(){
		$class_id = $_GET['class_id'];
		$query = M('Classes')->where('class_id = ' . $class_id . " and user_id = " . $this->user_id)->delete();
		if ($query) {
			ajaxReturn("删除成功");
		}else{
			ajaxReturn("删除失败");
		}
	}

	//添加学员
	public function addStudent(){

	}

	//布置作业
	public function addHomeWork(){

	}
}

?>
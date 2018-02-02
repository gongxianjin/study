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
		$class_id = (int)$_GET['class_id'];

		if (!isset($class_id)) {
			ajaxReturn("非法请求");
		}
		//班级信息
		$c = M('Classes')->where("class_id = " . $class_id . " and user_id = " . $this->user_id)->find();
		if (!$c) {
			ajaxReturn("非法请求");
		}

		//成员信息
		$stuList = D('Classstudentlist')->getStudents($class_id);

		$this->assign('class',$c);
		$this->assign('stuList',$stuList);
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
				'count' => 1,
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
		$class_id = (int)$_GET['class_id'];
		if (!isset($class_id)) {
			ajaxReturn("非法请求");
		}
		$query = M('User')->where('platform_id = ' . $this->platform_id)->field('id,nickname,head_img')->select();
		$this->assign('list',$query);
		$this->assign('class_id',$class_id);
		$this->display();
	}

	//ajax添加学院
	public function addStuFunc(){
		$class_id = (int)I('post.class_id');
		$list = I('post.list');
		if (!isset($class_id)) {
			ajaxReturn("非法请求");
		}

		$model = M('Classstudentlist');
		for($i = 0;$i < count($list);$i++){
			$stu = array(
					'teacher_id' => $this->user_id,
					'user_id' => (int)$list[$i],
					'class_id' => $class_id,
					'time' => time(),
				);
			if (!($model->where('user_id = ' . $list[$i] . " and class_id = " . $class_id)->find())) {
				$query = $model->add($stu);
				if (!$query) {
					ajaxReturn("添加失败");
				}else{
					//班级添加学生
					$count = (int)(M('Classes')->where('class_id = ' . $class_id)->getField('count'));
					$count++;
					M('Classes')->where('class_id = ' . $class_id)->setField('count',$count);
				}
			}
		}
		ajaxReturn("添加学生成功");
	}

	//班级作业
	public function homeworkManager(){
		$class_id = (int)$_GET['class_id'];
		if (!isset($class_id)) {
			ajaxReturn("非法请求");
		}

		$list = D('Classhomework')->getList($class_id);

		$this->assign('homeworks',$list);
		$this->assign('class_id',$class_id);

		$this->display();
	}

	//布置作业
	public function addHomework(){
		$class_id = (int)$_GET['class_id'];
		if (!isset($class_id)) {
			ajaxReturn("非法请求");
		}
		$query = M('classes')->where('class_id = ' . $class_id)->find();
		if (!$query) {
			ajaxReturn("暂无该班级");
		}else{
			//判断身份
			$isExit = M('Classstudentlist')->where('class_id = ' . $class_id . " and user_id = " . $this->user_id)->find();
			if (!$isExit || $this->user_type != 1) {
				ajaxReturn("非法请求");
			}
		}

		//找到该班级
		if ($query['count'] == 0) {
			ajaxReturn("班级中无同学,请先给班级添加同学");
		}else{
			$count = D('Classstudentlist')->getStudentCount($class_id);
			if ($count == 0) {
				ajaxReturn("班级中无同学,请先给班级添加同学");
			}else{
				//布置作业

			}
		}
		$this->assign('class_id',$class_id);
		$this->assign('bookList',M('Book')->select());
		$this->display();
	}

	public function addHomeworkFunc(){
		$post = I('post.');
		if ($this->user_type != 1) {
			ajaxReturn("非法请求");
		}
		if (!IS_POST) {
			ajaxReturn("非法请求");
		}

		$post['start'] .= " 00:00:00";
		$work = array(
				'course_id' => $post['course_id'],
				'teacher_id' => $this->user_id,
				'class_id' => $post['class_id'],
				//开始时间
				'start' => strtotime($post['start']),
				'end' => strtotime($post['start']) + (int)$post['use_day'] * 24 * 3600,
				'setup' => $post['setup'],
				'time' => time(),
				'day' => (int)$post['use_day'],
				'start_text_id' => $post['start_id'],
				'end_text_id' => $post['end_id']
			);
		$query = M('Classtasklist')->add($work);

		if ($query) {
			//给每个同学分配作业
			D('Classhomework')->addHomeworks($work);
			ajaxReturn("添加成功");
		}else{
			ajaxReturn("添加失败");
		}
	}

	//学生详情
	public function stuDetail(){
		$class_id = (int)$_GET['class_id'];
		$stu_id = (int)$_GET['stu_id'];

		if (!isset($class_id) || !isset($stu_id)) {
			ajaxReturn("非法请求");
		}

		$query = M('Classstudentlist')->where("class_id = " . $class_id . " and user_id = " . $stu_id)->find();
		if (!$query) {
			ajaxReturn("班级中没有此同学");
		}

		$res = D('UserFunds')->getFundsDetail($stu_id);
		$this->assign('res',$res);
		$this->assign('list',$res['scoreList']);
		$this->display();
	}

	//奖励分数
	public function awardScore(){
		if (!IS_POST) {
			ajaxReturn("非法请求");
		}
		$user_id = (int)I('post.user_id');
		$content = I('post.content');
		$award = (int)I('post.score');
		if (!isset($user_id)) {
			ajaxReturn("非法请求");
		}
		$score = (int)(M('UserFunds')->where('user_id = ' . $user_id)->getField('score'));
		$score += $award;
		M('UserFunds')->where('user_id = ' . $user_id)->setField('score',$score);
		$res = array(
				'user_id' => $user_id,
				'type' => 0,
				'score' => $award,
				//来源 临时设置
				'source' => 0,
				'value' => "临时设置来源",
				'time' => time(),
				'content' => $content
			);
		$query = M('UserScoreDetail')->add($res);
		if ($query) {
			ajaxReturn("奖励成功");
		}else{
			ajaxReturn("奖励失败,请联系管理员");
		}
	}

	public function getTextBooks(){
		$book_id = (int)I('post.book_id');
		if (!isset($book_id)) {
			ajaxReturn("非法请求");
		}

		$query = M('BookRes')->where('book_id = ' . $book_id)->select();
		// ajaxReturn($query);
		echo json_encode($query);
	}
}

?>
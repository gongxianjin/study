<?php

namespace Home\Model;
use Think\Model;

class ClasshomeworkModel extends Model{
	public function getList($class_id){
		$query = M('ClassTaskList')->where('class_id = ' . $class_id)->select();

		$res = array();
		foreach($query as $one){
			$course_id = M('ClassTaskList')->where('id = ' . $one['id'])->getField('course_id');
			$work = array(
					'id' => $one['id'],
					'name' => M('Book')->where('id = ' . $course_id)->getField('name'),
					'start' => date('m-d',(int)$one['start']),
					'end' => date('m-d',(int)$one['end'])
				);
			array_push($res, $work);
		}
		return $res;
	}

	public function addHomeworks($task){
		$class_id = $task['class_id'];
		//所有学生
		$stus = M('Classstudentlist')->where('class_id = ' . $class_id)->select();
		$homework = array(
				'class_id' => $class_id,
				'book_id' => $task['course_id'],
				'start' => $task['start'],
				'end' => $task['end'],
				'day' => $task['day'],
				'time' => time(),
				'status' => 0,
				'homework_id' => $task['homework_id']
			);
		foreach($stus as $stu){
			$homework['user_id'] = $stu['user_id'];
			$this->add($homework);
		}
	}

	public function getOneDayList($class_id,$day){
		$query = $this->where("class_id = {$class_id} and start <= {$day} and {$day}<= end")->select();
		foreach($query as &$one){
			$one['user_name'] = M('User')->where('id = ' . $one['user_id'])->getField('nickname');
			$one['head_img'] = M('User')->where('id = ' . $one['user_id'])->getField('head_img');
		}
		return $query;
	}
}
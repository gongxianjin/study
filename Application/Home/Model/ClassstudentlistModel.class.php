<?php

namespace Home\Model;
use Think\Model;

class ClassstudentlistModel extends Model {
	public function getStudents($class_id){
		if (!isset($class_id)) {
			return null;
		}

		//班级学生信息
		$stuList = M('Classstudentlist')->where('class_id = ' . $class_id)->select();

		$res = array();
		foreach($stuList as $one){
			$temp = M('User')->where('id = ' . $one['user_id']) ->find();
			//学生信息
			$stu = array(
				'id' => $one['user_id'], 
				'head_img' => $temp['head_img'],
				'name' => $temp['nickname'],
				'phone' => $temp['phone'],
				'type' => (int)$tenm['type'],
				'role' => ((int)$temp['type'] == 0 ? "学生" : "老师")
				);
			$temp = M('UserFunds')->where('user_id = ' . $one['user_id'])->find();
			$stu['score'] = $temp['score'];
			array_push($res, $stu);
		}

		//排序
		$count = count($res);
		for($i = 0;$i < $count;$i++){
			for($j = 0;$j < $count - $i - 1;$j++){
				if ((int)$res[$j]['role'] < (int)$res[$j + 1]['role']) {
					$tmp = $res[$j];
					$res[$j] = $res[$j + 1];
					$res[$j + 1] = $tmp;
				}
			}
		}
		
		return $res;
	}

	public function getStudentCount($class_id){
		$res = $this->getStudents($class_id);
		if ($res) {
			$count = 0;
			foreach($res as $one){
				if ($one['type'] == 0) {
					$count++;
				}
			}
			return $count;
		}else{
			return 0;
		}
	}
}
?>
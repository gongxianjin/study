<?php

namespace Home\Model;
use Think\Model;

class EnlistsModel extends Model{
	public function getList($user_id){
		$query = M('Enlists')->where('user_id = ' . $user_id. ' and  status = 1')->select();
		foreach($query as &$one){
			$one['activity_name'] = M('activity')->where('id = ' . $one['g_id'])->getField('name');
		}
		return $query;
	}

	public function setList($eid = 0,$platform_id, $user_id, $grade_id, $status = 0,$type=0){
 		$param['status'] = $status;
		if( $eid ){
			return $this->where(array('id'=>$eid))->save($param);
		}
		$param['platform_id'] = $platform_id;
		$param['user_id'] = $user_id;
		$param['g_id'] = $grade_id;
		$param['type'] = $type;
		$param['time'] = time();
		return $this->add($param);
	}

}

?>
<?php

namespace Home\Model;
use Think\Model;

class EnlistsModel extends Model{
	public function getList($user_id){
		$query = M('Enlists')->where('user_id = ' . $user_id)->select();
		foreach($query as &$one){
			$one['activity_name'] = M('activity')->where('id = ' . $one['g_id'])->getField('name');
		}
		return $query;
	}
}

?>
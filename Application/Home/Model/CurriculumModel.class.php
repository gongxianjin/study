<?php

namespace Home\Model;
use Think\Model;

class CurriculumModel extends Model
{

    public function setAdd($platform_id, $user_id, $grade_id)
    {
        return $this->add(array(
            'platform_id' => $platform_id,
            'user_id' => $user_id,
            'grade_id' => $grade_id,
        ));
    }

    public function courseList($user_id = false){
        $where = array();
        if( $user_id ){
            $where['curriculum.user_id'] = $user_id;
            $where['curriculum.status'] = 0;
        }
        return $this->where($where)
                ->join("LEFT JOIN `grade` ON `grade`.`id` = `curriculum`.`grade_id`")
                ->field("`grade`.`id` as `grade_id`,`grade`.`name` as `grade_name`,`grade`.`img` as `grade_img`")
                ->select();
    }

}
<?php

namespace Home\Model;
use Think\Model;

class ActivityCourseModel extends Model
{
    public function getCourseMap($activity_id)
    {
        return $this->where(array('activity_id'=>$activity_id))->field('grade_id,level_id,checked')->select();
    }
    public function setCourseMap($activity_id, array $courseMap)
    {
        $this->where(array('activity_id'=>$activity_id))->delete();
        $param = array();
        foreach($courseMap as $_course)
        {
            $_course = explode("|", $_course);
            $param[] = array(
                'activity_id' => $activity_id,
                'grade_id' => $_course[0],
                'level_id' => $_course[1],
                'checked' => $_course[2],
            );
        }
        return $this->addAll($param);
    }
}
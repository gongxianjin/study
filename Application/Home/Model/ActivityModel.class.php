<?php

namespace Home\Model;
use Think\Model;

class ActivityModel extends Model
{
    public function getActivityList($platform_id = 0, $user_id = 0, $grade_id = 0,$status = 0)
    {
        $where = array();
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $user_id ){
            $where['user_id'] = $user_id;
        }
        if( $grade_id ){
            $where['grade_id'] = $grade_id;
        }
        if($status){
            $where['status'] = $status;
        }
        return $this->where($where)->select();
    }
    public function activityList($platform_id = 0, $limit = 1000)
    {
        $where['status'] = 1;
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        return $this->where($where)->limit($limit)->select();
    }
    public function findFirst($activity_id)
    {
        return $this->where(array('id'=>$activity_id))->find();
    }
    public function setRelease($activity_id)
    {
        return $this->where(array('id'=>$activity_id))->save(array('status'=>1));
    }
    public function setClosure($activity_id)
    {
        return $this->where(array('id'=>$activity_id))->save(array('status'=>2));
    }
    public function setActivity($activity_id, $platform_id, $user_id, $activity_name
        ,$activity_start, $continuous, $start, $end, $is_repeat, $cover_img, $content)
    {
        $param['name'] = $activity_name;
        $param['activity_start'] = $activity_start;
        $param['continuous'] = $continuous;
        $param['start'] = $start;
        $param['end'] = $end;
        $param['is_repeat'] = $is_repeat;
        $param['cover_img'] = $cover_img;
        $param['content'] = $content;
        if( $activity_id ){
            return $this->where(array('id'=>$activity_id))->save($param);
        }
        $param['platform_id'] = $platform_id;
        $param['user_id'] = $user_id;
        $param['time'] = time();
        return $this->add($param);
    }
}
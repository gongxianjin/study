<?php

namespace Home\Controller;

class ActivityController extends Base
{
    public function index()
    {
        $Activity = new \Home\Model\ActivityModel();
        //老师
        if($this->user_type != 0){
            $this->assign('showData', $Activity->getActivityList(
                $this->platform_id,
                $this->user_id
            ));
        }else{
            $this->assign('showData', $Activity->getActivityList(
                $this->platform_id,0,0,1
            ));
        }
        $this->display();
    }

    public function create()
    {
        $default = array('content' => '', 'cover_img' => '', 'is_repeat' => '', 'end' => '', 'start' => '',
            'continuous' => 0, 'activity_start' => '', 'name' => '', 'id' => 0, 'courseMap' => array());
        $activity_id = I('get.activity_id', 0, 'intval');
        if( $activity_id )
        {
            $Activity = new \Home\Model\ActivityModel();
            $findFirst = $Activity->findFirst($activity_id);
            if(isset($findFirst['user_id']) && $findFirst['user_id'] == $this->user_id)
            {
                $default = $findFirst;
                $default['courseMap'] = D('ActivityCourse')->getCourseMap($activity_id);
            }
        }
        $this->assign($default);
        $this->display();
    }

    public function set()
    {
        $activity_name = I('post.activity_name', '', 'strval');
        if( ! $activity_name ){
            ajaxReturn('请填写活动名称');
        }
        $activity_start = I('post.activity_start', '', 'strval');
        if( ! $activity_start ){
            ajaxReturn('请选择活动的开始时间');
        }
        $continuous = I('post.continuous', 0, 'intval');
        if( ! $continuous ){
            ajaxReturn('请填写活动的持续天数');
        }
        $every_start = I('post.every_start', '', 'strval');
        if( ! $every_start ){
            ajaxReturn('请选择活动每天的开始时间');
        }
        $every_end = I('post.every_end', '', 'strval');
        if( ! $every_end ){
            ajaxReturn('请选择活动每天的结束时间');
        }
        $activity_img = I('post.activity_img', '', 'strval');
        if( ! $activity_img ){
            ajaxReturn('请选择活动封面');
        }

        $activity_id = I('post.activity_id', 0, 'intval');
        $content = I('post.content', '', 'strval');
        $repeat = (I('post.repeat', '', 'strval')=='no' ? 1 : 0);
        $course_map = I('post.course_map', array());

        $Activity = new \Home\Model\ActivityModel();
        $findFirst = $Activity->findFirst($activity_id);
        if($activity_id && (!isset($findFirst['user_id']) || $findFirst['user_id'] != $this->user_id)){
            ajaxReturn('修改的活动不存在');
        }
        $setActivity = $Activity->setActivity($activity_id, $this->platform_id, $this->user_id,
            $activity_name, $activity_start, $continuous, $every_start, $every_end, $repeat, $activity_img, $content);
        if($setActivity === false){
            ajaxReturn('操作失败');
        }
        D('ActivityCourse')->setCourseMap($activity_id?$activity_id:$setActivity, $course_map);
        ajaxReturn('操作成功',  0);
    }

    public function release()
    {
        $activity_id = I('post.activity_id', 0, 'intval');
        if( ! $activity_id ){
            ajaxReturn('缺少参数');
        }
        $activityModel = new \Home\Model\ActivityModel();
        $findFirst = $activityModel->findFirst($activity_id);
        if( ! isset($findFirst['user_id'])  || $findFirst['user_id'] != $this->user_id)
        {
            ajaxReturn('活动不存在');
        }
        if($activityModel->setRelease($activity_id) === false){
            ajaxReturn('操作失败');
        }
        ajaxReturn('操作成功', 0);
    }

    public function closure()
    {
        $activity_id = I('post.activity_id', 0, 'intval');
        if( ! $activity_id ){
            ajaxReturn('缺少参数');
        }
        $activityModel = new \Home\Model\ActivityModel();
        $findFirst = $activityModel->findFirst($activity_id);
        if( ! isset($findFirst['user_id'])  || $findFirst['user_id'] != $this->user_id)
        {
            ajaxReturn('活动不存在');
        }
        if($activityModel->setClosure($activity_id) === false){
            ajaxReturn('操作失败');
        }
        ajaxReturn('操作成功', 0);
    }

    public function details()
    {
        //用户类型
        $this->assign('user_type',$this->user_type); 
        //活动ID
	$activity_id = I('activity_id', 0, 'intval');
        if( ! $activity_id ){
            ajaxReturn('缺少参数');
        } 
        $this->assign('activity_id',$activity_id);
         // 报名人数
        $this->create();
    }

    public function curriculum()
    {
        $activity_id = I('activity_id', 0, 'intval');
        if( ! $activity_id ){
            ajaxReturn('缺少参数');
        }

        $activityModel = new \Home\Model\ActivityModel();
        $findFirst = $activityModel->findFirst($activity_id);
//        if( ! isset($findFirst['user_id'])  || $findFirst['user_id'] != $this->user_id)
//        {
//            ajaxReturn('活动不存在');
//        }
        if( empty($findFirst) )
        {
            ajaxReturn('活动不存在');
        }
        $this->assign('courseMap', W('List/getCourseList', array($activity_id)));
        $this->display();
    }




}
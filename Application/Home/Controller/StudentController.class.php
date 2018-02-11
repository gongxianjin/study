<?php

namespace Home\Controller;
use Weixin\Api\Weixin;

class StudentController extends Base
{ 

    public function index()
    {
        // $taskid = I('get.taskid', 0, 'intval');
        // if( ! $taskid ){
        //     ajaxReturn('缺少参数');
        // }
        // //获取该课程第一篇课文和语音
        // $this->assign('showData', D('ClassTaskList')->findBooks(
        //     $taskid
        // ));
        // //进入JSSDK
        // $jssdk = new Weixin();
        // $signPackage = $jssdk->GetSignPackage();
        // $this->assign('signPackage', $signPackage);
        $this->display();
    }


    public function tasklist()
    {
        $class_id = I('get.classid', 0, 'intval');
        if( ! $class_id ){
            ajaxReturn('缺少参数');
        }
        $this->assign('class', D('Classes')->findFirst($class_id));
        //提交作业次数
        $this->assign('taskcounts',M('class_task_list')->where(array('setup'=>1,'user_id'=>$this->user_id))->count());
        //老师姓名
        $this->assign('teacher', M('classstudentlist')->where(array('classstudentlist.user_id'=>$this->user_id,'classstudentlist.class_id'=>$class_id))->join("LEFT JOIN `user` ON `user`.`id` = `classstudentlist`.`teacher_id`")->field("`user`.`nickname` as `username`")->find());
        //今日作业完成情况
        $map['user_id'] = $this->user_id;
        $map['time'] = array('between',array(strtotime(date('Y-m-d'.'00:00:00',time())),strtotime(date('Y-m-d'.'00:00:00',time()+3600*24))));
        $classtask = M('classhomework')->where($map)->find();
//        dump($classtask);die;
        $this->assign('classtask',$classtask);
        $this->display();
    }

    public function course()
    {
        //班级课程 
        $this->assign('classes', D('Classstudentlist')->classesList($this->user_id));
        //活动课程
        $this->assign('Curriculum', D('Curriculum')->courseList($this->user_id));
        $this->display();
    }

    public function saveVoice(){
        //获取返回serverId
        $res = json_decode(file_get_contents('php://input'));
        if( empty($res) ){
            ajaxReturn('接口错误');
        }
        //上传语音有效期3天，可用微信多媒体接口下载语音到自己的服务器，此处获得的 serverId 即 media_id
        $weixin = new Weixin();
        $voiceName = $weixin->download_media($res->serverId);
        if($voiceName){
            ajaxReturn('success', 1, array('content'=>$voiceName));
        }else{
            ajaxReturn('fail', 0, array('content'=>'保存错误'));
        }
    }

    public function addRes(){
        $content_voice = I('post.content_voice', '', 'strval');
        if( ! $content_voice ){
            ajaxReturn('请上传录音');
        }
        $homework_id =  I('post.hid', 0, 'intval');
        if($this->setRes($homework_id, $content_voice) === false){
            ajaxReturn('操作失败');
        }
        //获得星星

        ajaxReturn('操作成功', 0);
    }

    public function setRes($homework_id, $content_voice)
    {
        $param['homework_id'] = $homework_id;
        $param['content_voice'] = $content_voice;
        $param['time'] = time();
        return M('homework_res')->add($param);
    }

    public function workDetail(){
        $user_id = (int)$_GET['id'];
        $task_id = (int)$_GET['task_id'];
        $query = M('homework_res')->where("user_id = {$user_id} and homework_id = {$task_id}")->find();
        $this->assign('work',$query);
        $this->display();
    }

}
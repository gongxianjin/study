<?php

namespace Home\Controller;

class UserController extends Base
{
    public function personal()
    {
        $this->assign('userInfo', D('User')->findFirst($this->user_id));
        //活动
        $this->assign('activity',D('Enlists')->getList($this->user_id));
        $this->display();
    }

    public function personal_infor()
    {
        $this->assign('userInfo', D('User')->findFirst($this->user_id));
        $this->display();
    }

    public function deposit_cash()
    {
        // $money = D('UserFunds')->getMoney($this->user_id);
        // $this->assign('money', $money);
        $g_id = (int)$_GET['g_id'];
        if (!isset($g_id)) {
            ajaxReturn("非法请求");
        }
        $query = D('Order')->getOrder($this->user_id,$g_id);
        if (!$query) {
            ajaxReturn("非法请求");
        }
        $this->assign('ac',$query);
        $this->display();
    }

    //退还保证金


    public function integral()
    {
        $this->assign('score', D('UserFunds')->getScore($this->user_id));
        $this->assign('detail', D('UserScoreDetail')->detailList($this->user_id, I('get.type', 0, 'intval')));
        $this->display();
    }

    public function setPersonal()
    {
        $head_img = I('post.head_img', '', 'strval');
        if( ! $head_img || ! preg_match("/^\w{32}\.[gif|jpeg|jpg|png]{3,4}$/", $head_img) ){
            ajaxReturn('选择头像');
        }
        $nickname = I('post.nickname', '', 'strval');
        if( ! $nickname ){
            ajaxReturn('请输入昵称');
        }
        $sexMap = array('', '男', '女');
        $sex = I('post.sex', '', 'strval');
        if( ! in_array($sex, $sexMap) ){
            ajaxReturn('请选择性别');
        }
        $birthday = I('post.birthday', '0000-00-00', 'strval');
        if(strtotime($birthday) === false){
            ajaxReturn('选择的生日有误');
        }
        $city = I('post.city', '', 'strval');
        $user = new \Home\Model\UserModel();
        if($user->setPersonal($this->user_id, $nickname, $head_img, array_search($sex, $sexMap), $birthday, $city) === false){
            ajaxReturn('保存失败');
        }
        ajaxReturn('保存成功', 0);
    }


    public function depositFunc(){
        $id = (int)I('post.id');
        if (!isset($id)) {
            ajaxReturn("非法请求");
        }
        //调用退款记录
        $query = M('Order')->where('id = ' . $id)->setField('order_status',2);
    }
}
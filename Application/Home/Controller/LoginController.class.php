<?php

namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller
{
    public function login()
    {
        if( session('?login_info') )
        {
            ajaxReturn("已登陆，点击关闭", 0, array('redirect_url'=> U('/')));
        }
        $phone = getPhone();
        $password = I('post.password', '');
        if( ! preg_match("/^[\w\!\@\#\$\%\^\&\*\(\)\_\+\|\\=\-\`\~\/\.\,\?\>\<]{6,20}$/", $password)  ){
            ajaxReturn("请输入密码，长度在6~20之间");
        }
        $userModel = D('User');
        $userInfo = $userModel->findPhone($phone);

        if( ! isset($userInfo['phone']) ){
            ajaxReturn("不存在的用户");
        }

        if( $userInfo['password'] != $userModel->password($password) ){
            ajaxReturn("密码不正确");
        }

        \Home\Model\Login::setLoginInfo($userInfo['id']);
        ajaxReturn("登陆成功", 0, array('redirect_url'=> U('/')));
    }

    public function register_()
    {
        $phone = getPhone();
        $code = I('post.code', 0, 'intval');

        \Home\Model\Login::checkCode($code, $phone);
        $password = I('post.password', '');
        if( ! preg_match("/^[\w\!\@\#\$\%\^\&\*\(\)\_\+\|\\=\-\`\~\/\.\,\?\>\<]{6,20}$/", $password)  ){
            ajaxReturn("请输入密码，长度在6~20之间");
        }

        $open_id = I('post.open_id', '');
        if($open_id && ! preg_match("/^\w{10,48}$/", $open_id)  ){
            ajaxReturn("错误的信息");
        }

        $userModel = D('User');
        if( $userModel->findPhone($phone) ){
            ajaxReturn('该账号已被注册');
        }

        if( ! D('User')->addUser($phone, $password, $open_id) ){
            ajaxReturn("注册失败");
        }
        ajaxReturn("注册成功", 0, array('redirect_url'=> U('login/index')));
    }

    public function findPassword()
    {
        $phone = getPhone();
        $code = I('post.code', 0, 'intval');
        \Home\Model\Login::checkCode($code, $phone);
        $password = I('post.password', '');
        if( ! preg_match("/^[\w\!\@\#\$\%\^\&\*\(\)\_\+\|\\=\-\`\~\/\.\,\?\>\<]{6,20}$/", $password)  ){
            ajaxReturn("请输入密码，长度在6~20之间");
        }
        $userModel = D('User');
        if( ! $userModel->findPhone($phone) ){
            ajaxReturn('该账号尚未注册');
        }
        if( ! $userModel->updatePassword($phone, $password) ){
            ajaxReturn('密码找回失败');
        }
        ajaxReturn('密码找回成功', 0);
    }

    public function getCode()
    {
        $phone = getPhone();
        $getCode = \Home\Model\Login::getCode($phone);

        // 短信发送

        ajaxReturn("验证码发送成功!", 0);
    }
}

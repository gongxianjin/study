<?php

namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        layout(false);
        $this->display();
    }

    public function login()
    {
        $account = I('post.account', '');
        if( ! $account ){
            $this->error('请输入账号');
        }

        $password = I('post.password', '');
        if( ! $password ){
            $this->error('请输入密码');
        }

        $userInfo = D('Admin')->findFirst($account, $password);
        if( ! isset($userInfo['id']) ){
            $this->error('账号或密码错误');
        }

        session('[start]');
        session('adminInfo', $userInfo);
        session('[pause]');
        redirect(U("index/index"));
    }

    public function logout()
    {
        session(null);
        redirect(U("login/index"));
    }
}
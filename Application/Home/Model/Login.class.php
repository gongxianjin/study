<?php

namespace Home\Model;

class Login
{
    public static function setLoginInfo($user_id)
    {
        session('[start]');
        session('login_info', array('user_id'=> $user_id ));
        session('[pause]');
        return true;
    }

    public static function checkLogin()
    {
        if( ! session('?login_info') )
        {
            ajaxReturn("login error", 0, array('redirect_url'=> U('login/index')));
        }
        return true;
    }

    public static function getLoginInfo()
    {
        $user_id = session('login_info.user_id');
        if( ! $user_id )
        {
            return array();
        }
        static $userInfo = array();
        if( ! $userInfo )
        {
            $user = new \Home\Model\UserModel();
            $userInfo = $user->findFirst($user_id);
        }
        return $userInfo;
    }

    public static function getCode($phone, $module = MODULE_NAME)
    {
        $getCode = rand(100000, 999999);
        $getCode = array(
            'time' => time(),
            'code' => $getCode,
        );
        S(strtolower($module) . '_code_'. $phone, $getCode);
        return $getCode;
    }

    public static function checkCode($code, $phone, $module = MODULE_NAME)
    {
        return true;
        $codeInfo = S(strtolower($module) . '_code_'. $phone);
        if( ! isset($codeInfo['code']) || $codeInfo['code'] != $code){
            ajaxReturn('验证码不正确');
        }
        if( $codeInfo['time'] < ( time() - ( 1 * 60 )) ){
            ajaxReturn('验证码已失效');
        }
        return true;
    }
}
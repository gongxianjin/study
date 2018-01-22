<?php

namespace Home\Controller;
use Think\Controller;

class Base extends Controller
{
    protected $user_id = 0;
    protected $user_type = 0;
    protected $user_phone = 0;
    protected $platform_id = 0;

    public function _initialize()
    {
        $userInfo = \Home\Model\Login::getLoginInfo();
        if( ! isset($userInfo['phone']))
        {
            if( IS_AJAX ){
                ajaxReturn("登陆", 0, array('redirect_url'=> U('login/index')));
            }
            header("Location: " . U('login/index'));
            exit;
        }
        $this->user_id = $userInfo['id'];
        $this->user_type = $userInfo['type'];
        $this->user_phone = $userInfo['phone'];
        $this->platform_id = $userInfo['platform_id'] ? $userInfo['platform_id'] : 1;
        if( ! method_exists($this, ACTION_NAME) )
        {
            $this->display();
            exit;
        }
    }

    public static function powerCheck()
    {

    }

    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '')
    {
        $power = array(
            'user/personal',
            'grade/index',
            'grade/create',
            'activity/index',
            'activity/create',
            'grade/homework',
        );
        $template = ($templateFile ? $templateFile : ucfirst(CONTROLLER_NAME) . '/' . ACTION_NAME);
        if( in_array(strtolower($template), $power) )
        {
            $template = ucfirst(CONTROLLER_NAME) . '/' . $this->roleMap[$this->user_type] . ACTION_NAME;
        }
        try{
            parent::display($template, $charset, $contentType, $content, $prefix);
        }catch(\Exception $e) {
            header('HTTP/1.1 404 Not Found');
        }
    }
    private $roleMap = array('student_', 'teacher_', 'teacher_');
}
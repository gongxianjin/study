<?php

namespace Admin\Controller;
use Think\Controller;

class Base extends Controller
{
    protected $admin_id = 1; // 用户ID  针对管理员使用
    protected $platform_id = 1;  // 所属平台ID

    public function _initialize()
    {
        if( ! session('?adminInfo') )
        {
            $this->redirect("login/index");
        }

        $this->admin_id = session('adminInfo.id');
        if( session('adminInfo.platform_id'))
        {
            $this->platform_id = session('adminInfo.platform_id');
        }


        if($this->platform_id &&  ! W('MenuPlatform/checkMenu'))
        {
           // header("HTTP/1.1 404 Not Found");
           // exit;
        }
    }
}

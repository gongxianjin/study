<?php
namespace Home\Controller;

class IndexController extends Base
{
    //首页
    public function index()
    {
        $this->assign('hotActivity', D('Activity')->activityList($this->platform_id, 3));
        $this->display();
    }
}
<?php
namespace Home\Controller;

class IndexController extends Base
{
    //首页
    public function index()
    {
        $this->assign('hotActivity', D('Activity')->activityList($this->platform_id, 3));
        $this->assign("user_type",(int)$this->user_type);
        if ((int)$this->user_type == 2) {
        	$db = M('User');
			//统计数据
			$this->assign('totalUser',$db->where('platform_id = ' . $this->platform_id . ' and type = 0')->count());
			$this->assign('usingUser',$db->where('platform_id = ' .$this->platform_id . ' and status = 0 and type = 0')->count());
			$this->assign('pastUser',$db->where('platform_id = ' .$this->platform_id . ' and status = 1 and type = 0')->count());
        }
        $this->display();
    }
}
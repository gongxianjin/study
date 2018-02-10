<?php
namespace Home\Controller;
use Think\Controller;
class ManagerController extends Base{
	public function index(){
		$res = D('UserFunds')->integrals();
		$this->assign('total',$res['total']);
		$this->assign('list',$res['list']);

		$this->display();
	}

	public function userManager(){
		$userManager = D('User');
		$this->assign('stuList',$userManager->getList(0,$this->platform_id));
		$this->assign('teaList',$userManager->getList(1,$this->platform_id));
		$this->display();
	}
}
?>
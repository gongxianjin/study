<?php
namespace Home\Controller;
/*
* 晨曦
* 教师端 - 创建作业
*/
class TestController extends Base{
	public function getBook(){
		$xx = $_GET['text'];
		echo "1 = ".$xx;
	}
}
?>
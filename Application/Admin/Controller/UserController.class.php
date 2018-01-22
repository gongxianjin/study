<?php

namespace Admin\Controller;

class UserController extends Base
{
    public function index()
    {
        $name = I('get.name', 0, 'strval');
        $this->assign(D('User')->userList($this->platform_id, $name));
        $this->display();
    }

    public function exchange()
    {
        $this->display();
    }
}
<?php

namespace Admin\Controller;

class ClassesController extends Base
{
    public function index()
    {
        $this->assign(D('Classes')->getClassesList($this->platform_id));
        $this->display();
    }
}
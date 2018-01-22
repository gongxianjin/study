<?php

namespace Admin\Controller;

class WeixinController extends Base
{
    public function index()
    {
        $platformModel = D('Platform');
        $this->assign($platformModel->getPlatformList());
        $this->display();
    }
}
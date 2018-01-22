<?php

namespace Weixin\Controller;
use Think\Controller;
use Weixin\Api\Weixin;

class PlatformController extends Controller
{
    public function component()
    {
        $weixin = new Weixin();
        $preauthcode = $weixin->preauthcode();



        var_dump($preauthcode);


        exit;




        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?";

        $url .=  "component_appid=" . C('weixin.app_id');
        $url .=  "&pre_auth_code=1";
        $url .=  "&redirect_uri=" . urlencode("http://" . $_SERVER['HTTP_HOST'] . '/weixin/callback/component');

        header("Location: {$url}");
    }








}
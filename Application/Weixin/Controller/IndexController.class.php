<?php

namespace Weixin\Controller;
use Think\Controller;

class IndexController extends Controller
{
    public function authorize()
    {
        $callback = urlencode("http://".$_SERVER['HTTP_HOST']. U('weixin/getCode'));
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $url .= "?appid=" . C('weixin.app_id');
        $url .= "&redirect_uri=" . $callback;
        $url .= "&response_type=code&scope=snsapi_userinfo#wechat_redirect";
        header("location: {$url}");
    }






}
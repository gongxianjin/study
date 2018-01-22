<?php

namespace Weixin\Api;

class Weixin
{

    public function componentloginpage()
    {
        $base_url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage";
        $base_url .= "?component_appid=" . C('weixin.app_id');
        $base_url .= "&pre_auth_code=" . $this->preauthcode();
        $base_url .= "&redirect_uri=" . urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        header("Location: {$base_url}");
    }

    public function preauthcode()
    {
        $base_url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=";
        $base_url .= $this->access_token();
        $result = HttpRequest::execute($base_url, array(
            'component_appid' => C('weixin.app_id')
        ), 'post');
        return $result;
    }

    public function access_token()
    {
        $access_token = F('weixin/cache/access_token');
        if( ! isset($access_token['expires_in'],$access_token['request_time'])
            || (time()-$access_token['request_time']) >= $access_token['expires_in'])
        {
            $base_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential";
            $base_url .= "&appid=". C('weixin.app_id');
            $base_url .= "&secret=". C('weixin.app_secret');
            $access_token = json_decode(HttpRequest::execute($base_url), true);
            $access_token['request_time'] = time();
        }

        if( ! isset($access_token['access_token']) ){
            return false;
        }

        F('weixin/cache/access_token', $access_token);
        return $access_token['access_token'];
    }
}
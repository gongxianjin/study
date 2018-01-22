<?php

namespace Home\Controller;
use Think\Controller;

class WeixinController extends Controller
{

    // 用户关注
    public function subscribe()
    {
//        $xml = file_get_contents('php://input');
//        $xml = '<xml><ToUserName><![CDATA[gh_c405cb35edec]]></ToUserName>
//<FromUserName><![CDATA[oWYSTw4i4oqaPpHWxKIBRBeesRc8]]></FromUserName>
//<CreateTime>1513238705</CreateTime>
//<MsgType><![CDATA[event]]></MsgType><Event><![CDATA[subscribe]]></Event><EventKey><![CDATA[]]></EventKey></xml>';

//        $xmls  = xml_parser_create();
//        xml_parse_into_struct($xmls, $xml, $param, $index);
//        xml_parser_free($xmls);
//        $toUserNameIndex = isset($index['TOUSERNAME']) ? $index['TOUSERNAME'][0] : false;
//        $EVENTIndex = isset($index['EVENT']) ? $index['EVENT'][0] : false;
//        var_dump($param[$EVENTIndex]['value']);
//        var_dump($param[$toUserNameIndex]['value']);
//        var_dump($param);

    }

    public function componentloginpage()
    {
        $callback = urlencode("http://".$_SERVER['HTTP_HOST']. U('weixin/bindComponent'));
        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage";
        $url .= "?appid=" . C('weixin.app_id');
        $url .= "&pre_auth_code=12";
        $url .= "&redirect_uri=" . $callback;
        $url .= "&auth_type=1";
        header("location: {$url}");
    }

    public function authorize()
    {
        $callback = urlencode("http://".$_SERVER['HTTP_HOST']. U('weixin/getCode'));
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $url .= "?appid=" . C('weixin.app_id');
        $url .= "&redirect_uri=" . $callback;
        $url .= "&response_type=code&scope=snsapi_userinfo#wechat_redirect";
        header("location: {$url}");
    }

    public function getCode()
    {
        $code = I("get.code", 0);
        if( ! $code )
        {
            header('HTTP/1.1 500 Internal Server Error');
            exit;
        }

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token";
        $url .= "?appid=" . C('weixin.app_id');
        $url .= "&secret=" . C('weixin.app_secret');
        $url .= "&code=". $code . "&grant_type=authorization_code";
        $result = json_decode(file_get_contents($url), true);

        if( ! isset($result['access_token']) ){
            $this->error("参数获取异常");
        }

        $userModel = D('User');
        $userInfo = $userModel->findOpenid($result['openid']);
        if( isset($userInfo['id']) )
        {
            D('Login')->setLoginInfo(array(
                'user_id' => $userInfo['id'],
                'user_phone' => $userInfo['phone'],
                'user_type' => $userInfo['type'],
                'is_child' => $userInfo['is_child'],
            ));
            redirect(U('/'));
            exit;
        }
        redirect(U('login/register', array('open_id'=> $result['openid'])));
    }
}
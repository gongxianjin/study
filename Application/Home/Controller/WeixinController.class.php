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

    public function refund($transaction_id,$out_refund_no,$total_fee,$refund_fee){  
        $config = $this->config;  
          
        //退款参数  
        $refundorder = array(  
            'appid'         => $config['appid'],  
            'mch_id'        => $config['mch_id'],  
            'nonce_str'     => self::getNonceStr(),  
            'transaction_id'=> $transaction_id,  
            'out_refund_no' => $out_refund_no,  
            'total_fee'     => $total_fee * 100,  
            'refund_fee'    => $refund_fee * 100  
        );  
        $refundorder['sign'] = self::makeSign($refundorder);  
          
        //请求数据,进行退款  
        $xmldata = self::array2xml($refundorder);  
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';  
        $res = self::curl_post_ssl($url, $xmldata);  
        if(!$res){  
            return array('status'=>0, 'msg'=>"Can't connect the server" );  
        }  
        // 这句file_put_contents是用来查看服务器返回的结果 测试完可以删除了  
        //file_put_contents('./log3.txt',$res,FILE_APPEND);  
          
        $content = self::xml2array($res);  
        if(strval($content['result_code']) == 'FAIL'){  
            return array('status'=>0, 'msg'=>strval($content['err_code']).':'.strval($content['err_code_des']));  
        }  
        if(strval($content['return_code']) == 'FAIL'){  
            return array('status'=>0, 'msg'=>strval($content['return_msg']));  
        }  
          
        return $content;  
    }  

}
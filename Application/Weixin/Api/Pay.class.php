<?php

namespace Weixin\Api;

class Pay
{
    public function common()
    {
        $content = file_get_contents("php://input");
        $xml = xml_parser_create();
        xml_parse_into_struct($xml, $content, $data);
        xml_parser_free($xml);
        $param = array();
        foreach($data as $item)
        {
            $tag = isset($item['tag']) ? strtolower($item['tag']) : false;
            if(!$tag || $tag == 'xml')
            {
                continue;
            }
            $param[$tag] = $item['value'];
        }
        $wxModel = new \Weixin\Api\Pay();
        if( ! isset(
            $param['out_trade_no'],
            $param['transaction_id'],
            $param['result_code'],
            $param['total_fee'],
            $param['sign']
        ) ){
            $this->returnMsg('缺少参数');
        }
        // 验证支付状态
        if($param['result_code'] != 'SUCCESS')
        {
            $this->returnMsg('支付未成功');
        }
        // 验证支付签名
        if($wxModel->paySign($param) !=  $param['sign'])
        {
            $this->returnMsg('订单签名不一致');
        }
        return $param;
    }



    public function returnMsg($return_msg = '', $return_code = false)
    {
        $return['return_code'] = "FAIL";
        if( $return_code ){
            $return['return_code'] = "SUCCESS";
        }
        if( $return_msg ){
            $return['return_msg'] = $return_msg;
        }
        exit($this->createXml($return));
    }

    public function getCode($out_trade_no, $total_fee, $notify_url, $body = '')
    {
        $open_id = $this->open_id();
        $unifiedorder = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $sendData['appid'] = C('weixin.app_id'); // 微信支付分配的公众账号ID（企业号corpid即为此appId
        $sendData['mch_id'] = C('weixin.mch_id'); // 微信支付分配的商户号
        $sendData['nonce_str'] = md5(rand(10000, 20000) . time()); // 随机字符串
        $sendData['body'] = $body; // 内容
        $sendData['out_trade_no'] = $out_trade_no; // 商户平台订单号
        $sendData['total_fee'] = $total_fee * 100;  // 以分为单位
        $sendData['spbill_create_ip'] = get_client_ip(); // 客户端IP
        $sendData['notify_url'] = $notify_url; // 回调地址
        $sendData['openid'] = $open_id; // JSAPI 此参数必须， 用户openid
        $sendData['trade_type'] = "JSAPI"; // JSAPI

        $sendData['sign'] = $this->paySign($sendData);
        $result = $this->httpRequest($unifiedorder, $this->createXml($sendData));
        $xml = xml_parser_create();
        xml_parse_into_struct($xml, $result, $data, $index);
        xml_parser_free($xml);

        $resultIndex = isset($index['RESULT_CODE'][0]) ? $index['RESULT_CODE'][0] : false;
        if($data[$resultIndex]['value'] != "SUCCESS")
        {
            return false;
        }

        $prepayIndex = isset($index['PREPAY_ID'][0]) ? $index['PREPAY_ID'][0] : false;
        $rd['appId'] = $sendData['appid'];
        $timeStamp = time();
        $rd["timeStamp"] = "$timeStamp";
        $rd['nonceStr'] = $sendData['nonce_str'];
        $rd['package'] = "prepay_id=" . $data[$prepayIndex]['value'];
        $rd['signType'] = "MD5";
        $rd['paySign'] = $this->paySign($rd);
        return $rd;
    }

    public function open_id()
    { 
        if (isset($_GET['code']))
        {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?";
            $url .= "appid=" . C('weixin.app_id');
            $url .= "&secret=" . C('weixin.app_secret');
            $url .= "&code=" . $_GET['code'];
            $url .= "&grant_type=authorization_code";
            $result = json_decode(file_get_contents($url), true); 
            if( ! isset($result['openid']) ){
                return false;
            }
            return $result['openid'];
        }
        $base_url =  "https://open.weixin.qq.com/connect/oauth2/authorize?";
        $base_url .= "appid=" . C('weixin.app_id');
        $base_url .= "&redirect_uri=" . urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $base_url .= "&response_type=code";
        $base_url .= "&scope=snsapi_base#wechat_redirect";
        if( IS_AJAX ){
            ajaxReturn("确定支付保证金么？", 0, array('redirect_url'=> $base_url));
        }
        header("Location: " . $base_url);
        exit;
    }

    private function createXml($data)
    {
        $xml = "<xml>";
        foreach ($data as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        return $xml . "</xml>";
    }

    public function paySign($data)
    {
        $buff = "";
        ksort($data);
        foreach ($data as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v))
            {
                $buff .= $k . "=" . $v . "&";
            }
        }
        return strtoupper(md5($buff . "key=" . C('weixin.key')));
    }

    private function httpRequest($url, $xml)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = curl_exec($ch);
        if( ! $result ){
            $result = curl_errno($ch);
        }
        curl_close($ch);
        return $result;
    }
}
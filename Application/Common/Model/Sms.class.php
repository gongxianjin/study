<?php

namespace Common\Model;

use Common\Model\top\request\AlibabaAliqinFcSmsNumSendRequest;
use Common\Model\top\TopClient;

class Sms
{
    private $add_key = "24745826";
    private $secret_key = "06cdfb17614f77810b62c3359a7b7c8a";


    public function send($phone, $code='123456')
    {


//        $topClient = new TopClient();
//
//        $smsSend = new AlibabaAliqinFcSmsNumSendRequest();
//
//        $smsSend->setRecNum();
//        $smsSend->setRecNum();
//        $smsSend->setRecNum();
//        $smsSend->setRecNum();




        return ;



        exit;
        $requestUrl = "http://gw.api.taobao.com/router/rest?";
        $sysParams["app_key"] = $this->add_key;
        $sysParams["v"] = "2.0";
        $sysParams["format"] = 'json';
        $sysParams["sign_method"] = "md5";
        $sysParams["method"] = 'alibaba.aliqin.fc.sms.num.send';
        $sysParams["timestamp"] = date("Y-m-d H:i:s");
        $sysParams["partner_id"] = 'top-sdk-php-20151012';
        $sysParams['sms_type'] = 'normal';
        $sysParams['sms_free_sign_name'] = '童学惠';
        $sysParams['sms_param'] = "\"{\"code\":\"1234\",\"name\":\"25234523452345\"}\"";
        $sysParams['rec_num'] = $phone;
        $sysParams['sms_template_code'] = 'SMS_118790077';
        $sysParams["sign"] = $this->generateSign($sysParams);
        foreach ($sysParams as $sysParamKey => $sysParamValue)
        {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }
        $requestUrl = substr($requestUrl, 0, -1);

       $result = $this->httReqeust($requestUrl);

        var_dump($result);
    }

    private function httReqeust($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt ( $ch, CURLOPT_USERAGENT, "top-sdk-php" );
        $reponse = curl_exec($ch);
        if (curl_errno($ch)){
            $reponse = curl_strerror($ch);
        }
        curl_close($ch);
        return $reponse;
    }

    protected function generateSign($params)
    {
        ksort($params);
        $stringToBeSigned = $this->secret_key;
        foreach ($params as $k => $v)
        {
            if(is_string($v) && "@" != substr($v, 0, 1))
            {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= $this->secret_key;
        return strtoupper(md5($stringToBeSigned));
    }
}
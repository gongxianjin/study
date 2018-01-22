<?php

namespace Weixin\Api;

class HttpRequest
{
    public static function execute($url, Array $param = array(), $method = 'get')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        if($method == 'post')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }
        $exec  = curl_exec($ch);
        if( curl_error($ch) ){
            $exec = curl_strerror($ch);
        }
        curl_close($ch);
        return $exec;
    }
}
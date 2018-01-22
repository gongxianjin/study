<?php

function ajaxReturn($message, $code=1, $data = array())
{
    $param = array(
        'code' => $code,
        'message' => $message,
        'data' => (is_array($data) ? $data : array())
    );
    if( IS_AJAX )
    {
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($param));
    }
    exit(include_once(__DIR__.DIRECTORY_SEPARATOR.'error.html'));
}

function imageDomain($images, $default = '')
{
    return ($images ? C('aliyun.oss_host').$images : $default);
}

function getPhone()
{
    $phone = I("phone", 0);
    // 长度验证
    if(!is_numeric($phone) || strlen($phone) != 11){
        ajaxReturn('请输入有效的手机号码');
    }
    // 验证手机号码是否有效
    if( ! preg_match("/^1[34578]\d{9}$/", $phone) ){
        ajaxReturn('不是一个有效的手机号码');
    }
    return $phone;
}


function sendCode()
{

}

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


    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => C('weixin.app_id'),
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("jsapi_ticket.php"));
        if ($data->expire_time < time()) {
            $accessToken = $this->access_token();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode(HttpRequest::execute($url), true);
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $this->set_php_file("jsapi_ticket.php", json_encode($data));
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    public function download_media($media_id){
        $base_url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=";
        $base_url .= $this->access_token();
        $base_url .= "&media_id=";
        $base_url .= $media_id;
        ob_start();
        readfile($base_url);
        $voice  = ob_get_contents();
        ob_end_clean();
//      $size = strlen($voice);
//      $fp = fopen('1.amr', 'a');
//      fwrite($fp, $voice);
//      fclose($fp);
        $filename = "wxupload_".time().rand(1111,9999);
        $amrfilename = $filename.".amr";
        $amrvoiceName = md5($amrfilename) . '.' . end(explode('.', $amrfilename));
        file_put_contents($amrvoiceName,$voice);
        //转码为mp3
        $mp3voiceName = $this->amrTransCodingMp3($amrvoiceName,$filename);
        $filePath = $_SERVER['DOCUMENT_ROOT'].$mp3voiceName;
        //上传到阿里云
        $upload = new \Common\Model\Upload();
        $upload->upload($mp3voiceName,$filePath);
        $voiceName = $mp3voiceName;
        //删除本地文件
        $this->deleteDownloadFile($amrvoiceName);
        $this->deleteDownloadFile($mp3voiceName);
        return $voiceName;
    }

    /**
     * 将amr格式转换成mp3格式
     *
     * @param $amr
     * @param $prefix_filename
     * @return mixed
     */
    public function amrTransCodingMp3($amr, $prefix_filename)
    {
        $msgId = $prefix_filename;
        $mp3 = $msgId.'.mp3';
        $dir = $_SERVER['DOCUMENT_ROOT'];

        exec("ffmpeg -y -i ".$dir.$amr." ".$dir.$mp3);
        return $mp3;
    }
    /**
     * 删除本地音频文件
     *
     * @param $filename
     * @return bool
     * @throws ParameterException
     */
    public function deleteDownloadFile($filename)
    {
        $filename = $_SERVER['DOCUMENT_ROOT'].$filename;
        if (!unlink($filename))
        {
             return false;
        }
        else
        {
            return true;
        }
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

    private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }

}
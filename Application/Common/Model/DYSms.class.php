<?php

namespace Common\Model;

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest; 

class DYSms{

	private $app_key = '24745826';
	private $app_secret = "06cdfb17614f77810b62c3359a7b7c8a";
	//短信模板
	private $sms_code = array(
			//注册
			"register" => "SMS_118790077",
			//密码找回
			"lostPwd" => "SMS_118785067"
		);
	 /**
     * 数据处理
     */
    public function send_register_message($phone){
        // $phone=I("post.phone");

        //查找是否已经注册
        $user = D('User') -> where("phone = {$phone}") -> find();
        if ($user) {
            ajaxReturn("该手机号已注册");
        }else{
        	//发送短信
            $this->sendSms($phone,$this->sms_code['register']);
        }
    } 

    /**
     * 生成短信验证码
     * @param  integer $length [验证码长度]
     */
    public function createSMSCode($length = 4){
        $min = intval(pow(10 , ($length - 1)));
        $max = intval(pow(10, $length) - 1);
        return rand($min, $max);
    }

    /**
     * 发送验证码
     * @param  [integer] $phone [手机号]
     */
    public function sendSms($phone,$sms_code){
        require_once  APP_PATH . 'Common/Model/SmsApi/TopSdk.php';    //此处为你放置API的路径
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;

        $c->appkey = $this->app_key;
        $c->secretKey = $this->app_secret;
        $templateCode = $sms_code;   //短信模板ID
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "" );
        $req ->setSmsType( "normal" );
        $req ->setSmsFreeSignName( "童学惠" );

//        $code=$this->createSMSCode($length = 4);
        $rescode = \Home\Model\Login::getCode($phone); 
        $smsData = array('code'=>strval($rescode['code']),
            'name'=> 'txh'
            );    //所使用的模板若有变量 在这里填入变量的值  我的变量名为username此处也为username
        $SmsParam = json_encode($smsData); 
        $req ->setSmsParam($SmsParam);
        $req ->setRecNum($phone);
        $req ->setSmsTemplateCode( $templateCode ); 
        $resp = $c ->execute( $req );  
	$resp = (array)$resp;
        if ($resp['code']) {
            $data="发送失败";
        } else{
            $result = (array)$resp['result'];
            if($result['success']){
                $data="发送成功";
            }else{
                $data="发送失败";
            }
        }
        echo $data;
    }




    /**
     * 发送验证码
     * @param  [integer] $phone [手机号]
     */
    public function send_phone($phone,$sms_code){
        $code=$this->createSMSCode($length = 4);

        require_once  APP_PATH . 'Common/Model/Dayu/vendor/autoload.php';    //此处为你放置API的路径
        Config::load();             //加载区域结点配置

        $accessKeyId = $this->app_key;
        $accessKeySecret = $this->app_secret;
        $templateCode = $sms_code;   //短信模板ID

        //短信API产品名（短信产品名固定，无需修改）
        $product = "Dysmsapi";

        //短信API产品域名（接口地址固定，无需修改）
        $domain = "dysmsapi.aliyuncs.com";

        //暂时不支持多Region（目前仅支持cn-hangzhou请勿修改）
        $region = "cn-hangzhou";

        // 初始化用户Profile实例
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

        // 增加服务结点
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);

        // 初始化AcsClient用于发起请求
        $acsClient = new DefaultAcsClient($profile);

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($phone);

        // 必填，设置签名名称
        $request->setSignName("童学惠");

        // 必填，设置模板CODE
        $request->setTemplateCode($sms_code);

        $smsData = array('code'=>$code,
        				'name'=> 'name'
        			);    //所使用的模板若有变量 在这里填入变量的值  我的变量名为username此处也为username

        //选填-假如模板中存在变量需要替换则为必填(JSON格式),友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $request->setTemplateParam(json_encode($smsData));

        //发起访问请求
        $acsResponse = $acsClient -> getAcsResponse($request);
        //返回请求结果
        $result = json_decode(json_encode($acsResponse), true);
        $resp = $result['Code'];
        $this->sendMsgResult($resp,$phone,$code);
    }

    /**
     * 验证手机号是否发送成功  前端用ajax，发送成功则提示倒计时，如50秒后可以重新发送
     * @param  [json] $resp  [发送结果]
     * @param  [type] $phone [手机号]
     * @param  [type] $code  [验证码]
     * @return [type]        [description]
     */
    private function sendMsgResult($resp,$phone,$code){
        if ($resp == "OK") {
            $data['phone']=$phone;
            $data['code']=$code;
            $data['send_time']=time();
            $result=D("Smsverif")->add($data);
            if($result){
                $data="发送成功";
            }else{
                $data="发送失败";
            }
        } else{
            $data="发送失败";
        }
        echo $data;
    }

    /**
     * 验证短信验证码是否有效,前端用jquery validate的remote
     * @return [type] [description]
     */
    public function checkSMSCode($phone,$code){
        // $phone = $_POST['phone'];
        // $code = $_POST['verify'];
        $nowTimeStr = time();
        $smscodeObj = D("Smsverif")->where("phone={$phone} and code = {$code}")->find();
        if($smscodeObj){
            $smsCodeTimeStr = $smscodeObj['send_time'];
            $recordCode = $smscodeObj['code'];
            $flag = $this->checkTime($nowTimeStr, $smsCodeTimeStr);
            if($flag!=true || $code !== $recordCode){
                // echo 'no';
                return false;
            }else{
                // echo 'ok';
                return true;
            }
        }
    }

    /**
     * 验证验证码是否在可用时间
    *  @param  [json] $nowTimeStr  [发送结果]
     * @param  [type] $smsCodeTimeStr [手机号]
     */
    public function checkTime ($nowTimeStr,$smsCodeTimeStr) {
        $time = $nowTimeStr - $smsCodeTimeStr;
        if ($time>900) {
            return false;
        }else{
            return true;
        }
    }

    //test 

    public function test(){
        require_once  APP_PATH . 'Common/Model/Dayu/vendor/autoload.php';    //此处为你放置API的路径
    	require_once(APP_PATH . 'Common/Model/api_demo/SmsDemo.php');
    	header('Content-Type: text/plain; charset=utf-8');  
          
        $demo = new SmsDemo(  
            "24745826",  
            "06cdfb17614f77810b62c3359a7b7c8a"  
        );  
          
        echo "SmsDemo::sendSms\n";  
        $response = $demo->sendSms(  
            "童学惠", // 短信签名  
            "SMS_118790077", // 短信模板编号  
            "13020099366", // 短信接收者  
            Array(  // 短信模板中字段的值  
                "code"=>"12345",  
                "name"=>"dsd"  
            )  
        );  
        print_r($response);  
  
        if($response->Code == 'OK'){  
            echo "1";  
        }else{  
            echo "0";
        }  

    }
}

?>
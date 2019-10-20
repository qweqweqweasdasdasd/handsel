<?php 
namespace App\Libs\Sms;

use App\Libs\Sms\REST;

/**
 * 	发送短信
 */
class RLYsms
{
	//主帐号
	protected $accountSid= '8a216da863b5b9c20163bf9059080483';

	//主帐号Token
	protected $accountToken= '1e121a6545ac4c7e96b2ba448565559e';

	//应用Id
	protected $appId='8a216da863b5b9c20163bf90596c048a';

	//请求地址，格式如下，不需要写https://
	protected $serverIP='app.cloopen.com';

	//请求端口 
	protected $serverPort='8883';

	//REST版本号
	protected $softVersion='2013-12-26';

	/**
	 *	发送短信
	 */
	public function sendTemplateSMS($to,$datas,$tempId)
	{
		// 初始化REST SDK
     	$rest = new \App\Libs\Sms\REST($this->serverIP,$this->serverPort,$this->softVersion);
     	$rest->setAccount($this->accountSid,$this->accountToken);
     	$rest->setAppId($this->appId);
    
     	// 发送模板短信
     	$result = $rest->sendTemplateSMS($to,$datas,$tempId);
	    if($result == NULL ) {
	  
	        throw new \Exception("result error!", 0);
	    }
	    if($result->statusCode!=0) {
	    
	        $res = json_decode(json_encode($result));
	        throw new \Exception($res->statusMsg, $res->statusCode);
	         
	    }else{
	     
	        $smsmessage = $result->TemplateSMS;
	       
	        $sms = json_decode(json_encode($smsmessage));
	        $data = [
	        	'dateCreated'=>$sms->dateCreated,
	        	'smsMessageSid'=>$sms->smsMessageSid
	        ];
	        return $data; 
	    }
	}
}
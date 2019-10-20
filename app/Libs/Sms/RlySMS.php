<?php 
namespace App\Libs\Sms;

use App\Libs\Sms\RLY_SMS\SDK\CCPRestSDK;

/**
 * 发送荣联运短信
 */
class RlySMS
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


	public function __construct()
	{
		
	}

	/**
	  * 发送模板短信
	  * @param to 手机号码集合,用英文逗号分开
	  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
	  * @param $tempId 模板Id'
	  * //Demo调用,参数填入正确后，放开注释可以调用 
	  *	//sendTemplateSMS("手机号码","内容数据","模板Id");
	  */
	public function sendTemplateSMS($to,$datas,$tempId)
	{
		$rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
	    $rest->setAccount($this->accountSid,$this->accountToken);
	    $rest->setAppId($this->appId);
	    $result = $rest->sendTemplateSMS($to,$datas,$tempId);

	    if($result == NULL ) {
	        throw new \Exception("result error!",0);
	    }

	    if($result->statusCode!=0) {
	    	$result = json_decode(json_encode($result));
	        throw new \Exception($result->statusMsg, $result->statusCode); 
	    }else{
	        //echo "Sendind TemplateSMS success!<br/>";
	        // 获取返回信息
	        $smsmessage = $result->TemplateSMS;
	        //echo "dateCreated:".$smsmessage->dateCreated."<br/>";
	        //echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
	        $smsmessage = json_decode(json_encode($smsmessage));
	        $data = [
	        	'dateCreated'=>$smsmessage->dateCreated,
	        	'smsMessageSid'=>$smsmessage->smsMessageSid
	        ];
	        return $data;
	    }
	   
	}
}
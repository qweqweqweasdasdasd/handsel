<?php

namespace App\Http\Controllers\Server;

use App\SmsLog;
use App\Libs\Sms\RlySMS;
use Illuminate\Http\Request;
use App\Resphonse\JsonResphonse;
use App\Http\Requests\SMSRequest;
use App\Http\Controllers\Controller;

class SMSController extends Controller
{
	protected $tempId = '254678';

	protected $validtime = '5';	
    /**
	 * 人工短信邀请页面  view
     */
    public function invite()
    {
    	return view('admin.sms.invite');
    }

    /**
     *	发送短信逻辑
     */
    public function sendSMS(SMSRequest $request)
    {
    	$to =  !empty($request->get('phone'))?$request->get('phone'):'';
    	if(empty($to)){
    		return JsonResphonse::JsonData('0','手机号码为空!');
    	}
    		
    	// 邀请时间核对 5分钟内
    	$random_code = mt_rand(111111,999999);
    	$datas = array($random_code,$this->validtime);
    	$content = "您的验证码为{$random_code},请于{$this->validtime}内正确输入,打死都不要告诉别人哦!";
    	$data = [
    		'phone' => $to,
    		'code' => $random_code,
    		'content' => $content,
    		'handlers' => \Auth::guard('admin')->user()->mg_id,
    		'type' => '1'
    	];
    	$smslog = SmsLog::create($data);
    	//dd($smslog);
    	try {
    		$sms = new RlySMS();
    		$res = $sms->sendTemplateSMS($to,$datas,$this->tempId);
    	} catch (\Exception $e) {
    		//return ['code'=>$e->getCode(),'msg'=>$e->getMessage()];
    		$smslog->desc = $e->getMessage();
    		$smslog->sms_status = '2';
    		$smslog->save();
    		return JsonResphonse::JsonData('0',$e->getMessage());
    	}

    	// 发送短信成功 || 写入短信记录 1,手机号码 2,验证码 3,发送时间 6, 模板内容 5, 操作者
    	// 4,模板信息{"dateCreated":"20190916170352","smsMessageSid":"daa5156add264759b611cc0cf161a08c"}, 


    	//return $res = {"dateCreated":"20190916170352","smsMessageSid":"daa5156add264759b611cc0cf161a08c"}
    	$data = [
    		'msg' => '短信发送成功,请不要重复发送哦!',
    		'code' => $random_code
    	];
    	$smslog->desc = $data['msg'];
    	$smslog->sms_status = '1';
    	$smslog->save();
    	return JsonResphonse::ResphonseSuccess($data);
    }
}

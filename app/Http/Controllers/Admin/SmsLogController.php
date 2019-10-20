<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SmsLogRepository;
use App\Repositories\ManagerRepository;

class SmsLogController extends Controller
{
	/**
     * 短信列表仓库
     */
    protected $smsLog;

    /**
     * 管理员列表仓库
     */
    protected $manager;

    /**
     * 初始化仓库
     */
    public function __construct(SmsLogRepository $smsLog,ManagerRepository $manager)
    {
        $this->smsLog = $smsLog;
        $this->manager = $manager;
    }

    /**
	 * 短信历史记录
     */
    public function index(Request $request)
    {
    	$whereData = [
    		'phone' => !empty($request->get('phone'))?$request->get('phone'):'',
    		'start' => !empty($request->get('start'))? $request->get('start') :'',
            'end' => !empty($request->get('end'))? $request->get('end') :'',
            'sms_status' => !empty($request->get('sms_status'))? $request->get('sms_status') :''
    	];
    	$pathInfo = $this->smsLog->getCurrentPathInfo();
    	$smsLogs = $this->smsLog->GetSmsLogs($whereData);

    	$GetManagerIdName = $this->manager->GetManagerIdName();

    	foreach ($smsLogs as $k => $v) {
    		$v->handlers = $GetManagerIdName[$v->handlers];
    	}
        //dump($smsLogs);
    	return view('admin.smslog.index',compact('pathInfo','smsLogs','whereData'));
    }
}

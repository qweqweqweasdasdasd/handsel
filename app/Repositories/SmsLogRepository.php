<?php

namespace App\Repositories;

use DB;
use App\SmsLog;

class SmsLogRepository extends BaseRepository
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->table = 'sms_log';
        $this->id = 'sms_log_id';    
    }

    /**
     * 短信数据
     */
    public function GetSmsLogs($d)
    {
    	return SmsLog::where(function($query) use($d){
    				if( !empty($d['phone'])){
    					$query->where('phone',$d['phone']);
    				}
                    if( !empty($d['sms_status'])){
                        $query->where('sms_status',$d['sms_status']);
                    }
    				if( !empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                        $query->whereBetween('created_at',[$d['start'],$d['end']] );
                    }
    			})
		    	->orderBy('sms_log_id','desc')
		    	->paginate(11);
    }
}
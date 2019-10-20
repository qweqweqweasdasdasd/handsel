<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $primaryKey = 'sms_log_id';
	protected $table = 'sms_log';
    protected $fillable = [
    	'phone','code','content','handlers','type','sms_status','desc'
    ];

    
}

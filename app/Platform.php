<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $primaryKey = 'platform_id';
	protected $table = 'platform';
    protected $fillable = [
    	'pf_name','mark','token','platform_status'
    ];

    /**
     *	平台和活动多对多关系
     */
   	public function activity()
   	{
   		return $this->belongsToMany('App\Activity','platform_activity','platform_id','activity_id')->withTimestamps();
   	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $primaryKey = 'activity_id';
	protected $table = 'activity';
    protected $fillable = [
    	'activity_name','activity_money','activity_status','desc'
    ];

    /**
     *	活动和平台多对多关系
     */ 
    public function platform()
    {
    	return $this->belongsToMany('App\Platform','platform_activity','activity_id','platform_id')->withTimestamps();
    }
}

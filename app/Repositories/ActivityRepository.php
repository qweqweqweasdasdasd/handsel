<?php

namespace App\Repositories;

use DB;
use App\Activity;

class ActivityRepository extends BaseRepository
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->table = 'activity';
        $this->id = 'activity_id';    
    }

    /**
     *	获取到指定的一条活动
     */
    public function ActivityFirstWithPlatform($id)
    {
    	return Activity::with('platform')->find($id);
    }

    /**
	 *	指定一条活动的更新
	 */
    public function ActivityUpdate($id,$d)
    {
    	$activity = Activity::find($id);
    	$activity->activity_name = $d['activity_name'];
    	$activity->activity_money = $d['activity_money'];
    	$activity->activity_status = $d['activity_status'];
    	$activity->desc = $d['desc'];
    	$activity->save();
    	return $activity;
    }

    /**
     *	删除指定的活动
     */
    public function ActivityPlatformDelete($id)
    {
    	return DB::table('platform_activity')->where('activity_id',$id)->delete();
    }

    /**
     *	获取到活动所有数据
     */
    public function GetActivity($d)
    {
    	return Activity::with('platform')
                    ->where(function($query) use($d){
                        if( !empty($d['keyword']) ){
                            $query->where('activity_name',$d['keyword'])
                                  ->orWhere('activity_money',$d['keyword']);
                        } 
                        if( !empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                            $query->whereBetween('created_at',[$d['start'],$d['end']] );
                        }
                    })
    				->orderBy('activity_id','desc')
    				->paginate(9);
    }

    /**
     *	保存活动数据
     */
    public function ActivitySave($data)
    {
    	return Activity::create($data);
    }

    /**
     *  活动名称和id
     */
    public function GetActivityNameID()
    {
        return Activity::orderBy('activity_id','desc')
                    ->get([
                        'activity_id',
                        'activity_name',
                        'activity_status'
                    ]);
    }
}
<?php

namespace App\Repositories;

use DB;
use App\Platform;
use App\Libs\Admin\AdminData;

class PlatformRepository extends BaseRepository
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->table = 'platform';
        $this->id = 'platform_id';    
    }

    /**
     *  保存平台数据
     */
    public function PlatformSave($data)
    {
        return Platform::create($data);
    }

    /**
     *  获取到指定一条数据
     */
    public function PlatformWithActivity($id)
    {
        return Platform::with('activity')->find($id);
    }

    /**
     *  更新指定的活动
     */
    public function PlatformUpdate($id,$data)
    {
        $platform = Platform::find($id);
        $platform->pf_name = $data['pf_name'];
        $platform->mark = $data['mark'];
        $platform->platform_status = $data['platform_status'];
        $platform->token = $data['token'];
        $platform->save();
        return $platform;
    }

    /**
     *  删除平台和活动关系
     */
    public function PlatformActivityDelete($id)
    {
        return DB::table('platform_activity')->where('platform_id',$id)->delete();
    }

    /**
     *	获取到平台所有数据
     */
    public function GetPlatform($d)
    {
        $platform_id = (new AdminData)->ManagerPlatform();
        //dump($platform_id);
    	return Platform::where(function($query) use($d,$platform_id){
                            if( !empty($platform_id) ){
                                $query->where('platform_id',$platform_id);
                            }
                            if( !empty($d['keyword']) ){
                                $query->where('pf_name',$d['keyword']);
                            } 
                            if( !empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                                $query->whereBetween('created_at',[$d['start'],$d['end']] );
                            }
                        })
                        ->orderBy('platform_id','desc')
                        ->paginate(9);
    }

    /**
     *  获取到平台名和id
     */
    public function GetPfNameId()
    {
        return Platform::orderBy('platform_id','desc')
                        ->get([
                                'platform_id',
                                'pf_name',
                                'platform_status',
                                'mark'
                            ]);
    }
}
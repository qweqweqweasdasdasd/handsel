<?php

namespace App\Repositories;

use DB;
use App\Apply;
use Illuminate\Support\Facades\Schema;

class UserRepository extends BaseRepository
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->table = 'user';
        $this->id = 'user_id';    
    }

    /**
     *	获取会员数据
     */
    public function GetApplys($d)
    {
        $table = (new Apply)->setTable('apply')->table;

        // 不存在表 返回一个空白分页表
        if(!Schema::hasTable($table)){
            return \DB::table('empty')->paginate();
        }
        
    	$data = (new Apply)->setTable('apply')
            ->where(function($query) use($d){
    			if(!empty($d['phone'])){
    				$query->where('phone',$d['phone']);
    			}
    			if( !empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                    $query->whereBetween('created_at',[$d['start'],$d['end']] );
                }
	    	})
            ->orderBy('apply_id','desc')
	    	->paginate(13);

        return $data;
    }

    /**
     *	获取会员总数
     */
    public function count($d)
    {
        $table = (new Apply)->setTable('apply')->table;

        // 不存在表 返回一个空白分页表
        if(!Schema::hasTable($table)){
            return \DB::table('empty')->paginate();
        }

    	return (new Apply)->setTable('apply')
            ->where(function($query) use($d){
    			if(!empty($d['phone'])){
    				$query->where('phone',$d['phone']);
    			}
    			if( !empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                    $query->whereBetween('created_at',[$d['start'],$d['end']] );
                }
	    	})
	    	->count();
    }
}
<?php

namespace App\Repositories;

use DB;
use App\Handsel;
use Illuminate\Support\Facades\Schema;

class HandselRepository extends BaseRepository
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->table = 'handsel';
        $this->id = 'handsel_id';    
    }

    /**
     *	获取彩金数据
     */
    public function GetHandsel($d)
    {
      $table = (new Handsel)->setTable('handsel')->table;
      
      // 不存在表 返回一个空白分页表
      if(!Schema::hasTable($table)){
          return \DB::table('empty')->paginate();
      }

    	$data = (new Handsel)->setTable('handsel')
          ->where(function($query) use($d){
      			   if(!empty($d['keyword'])){
      				        $query->where('phone',$d['keyword'])
                            ->orWhere('username',$d['keyword']);
      			   }
      			   if(!empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                      $query->whereBetween('created_at',[$d['start'],$d['end']] );
               }
  	    	})
      		->orderBy('handsel_id','desc')
  	    	->paginate(13);

      return $data;
    }

    /**
     *	获取彩金数量
     */
    public function count($d)
    {
      $table = (new Handsel)->setTable('handsel')->table;

      // 不存在表 返回一个空白分页表
      if(!Schema::hasTable($table)){
          return \DB::table('empty')->count();
      }

    	$data = (new Handsel)->setTable('handsel')
          ->where(function($query) use($d){
              if(!empty($d['keyword'])){
                      $query->where('phone',$d['keyword'])
                            ->orWhere('username',$d['keyword']);
              }
              if( !empty($d['start']) && !empty($d['end']) &&  $d['end'] >= $d['start']){
                      $query->whereBetween('created_at',[$d['start'],$d['end']] );
              }
          })
          ->count();

      return $data;
    }
}
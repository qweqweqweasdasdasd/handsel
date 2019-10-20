<?php

namespace App\Repositories;

use DB;
use Illuminate\Support\Facades\Redis;


class TokenRepository extends BaseRepository
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->table = '';
        $this->id = '';    
    }

    /**
     *	令牌保存
     */
    public function TokenSaveWitchRedis($key,$data)
    {
    	return !!Redis::hmset($key,$data);
    }

    /**
     *	获取到token	
     */
    public function getPfToken($key)
    {
    	return Redis::hmget($key,['token','status']);
    }
}
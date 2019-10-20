<?php 
namespace App\Libs\Admin;

use Illuminate\Support\Facades\Redis;

/**
 * 平台存储redis 
 */
class PlatformRedis
{
	/**
	 *	平台列表集合
	 */
	protected $key = 'platform_mark_list';

	/**
	 *	关系表
	 */
	protected $relation = 'relation_activity_';

	/**
	 *	平台删除
	 */
	public function delete($mark)
	{
		Redis::del(strtolower($mark));
		Redis::srem($this->key,strtolower($mark));
	}

	/**
	 *	平台状态更新
	 */
	public function update_status($mark,$status)
	{
		$data = json_decode(Redis::get(strtolower($mark)));
		$data->platform_status = $status;
		Redis::set(strtolower($mark),json_encode($data));
	}

	/**
	 *	平台存储 创建  使用同一个条 api 
	 */
	public function store($platform,$activity_ids)
	{
		$data = [
			'platform_id' => $platform->platform_id,
			'pf_name' => $platform->pf_name,
			'platform_status' => $platform->platform_status,
			'token' => $platform->token,
		];
		
		// 存储平台列表
		Redis::sadd($this->key,strtolower($platform->mark));
		Redis::set(strtolower($platform->mark),json_encode($data));

	}


}
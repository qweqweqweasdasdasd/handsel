<?php 
namespace App\Libs\Admin;

use Illuminate\Support\Facades\Redis;

/**
 * 活动存储redis 
 */
class ActivityRedis
{
	/**
	 *	活动列表集合
	 */
	protected $key = 'activity_';

	/**
	 *	活动删除
	 */
	public function delete($activity_id)
	{
		$key = $this->key . $activity_id;
		Redis::del($key);
	}

	/**
	 *	活动状态更新
	 */
	public function update_status($activity_id,$status)
	{
		$key = $this->key.$activity_id;
		$data = json_decode(Redis::get($key));
		$data->activity_status = $status;
		Redis::set($key,json_encode($data));
	}

	/**
	 *	活动存储 创建 || 更新 使用同一个条 api 
	 */
	public function store($activity)
	{
		$data = [
			'activity_id' => $activity->activity_id,
 			'activity_name' => $activity->activity_name,
 			'activity_money' => $activity->activity_money, 
 			'activity_status' => $activity->activity_status, 
		];
		$key = $this->key.$activity->activity_id;
		// 存储活动列表
		Redis::set($key,json_encode($data));
		// 关系表
	}

}
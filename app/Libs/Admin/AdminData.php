<?php 
namespace App\Libs\Admin;

use App\Manager;
use App\Platform;
use Illuminate\Support\Facades\Redis;
use App\Repositories\ActivityRepository;

/**
 * 
 */
class AdminData
{
	/**
	 *	保存管理员-所属平台-拥有彩金活动数据 redis-key
	 */
	protected $key = 'root_platform_activity';

	/**
	 *	当前管理员
	 */
	protected $admin = '';

	/**
	 * 	初始化数据
	 */
	public function __construct()
	{
		$this->admin = \Auth::guard('admin')->user();
		
	}

	/**
	 *	管理员标识
	 */
	public function admin_mark()
	{
		$platform_id = $this->admin->platform_id;

		return Platform::find($platform_id)->mark;

	}

	/**
	 *	判断管理员是否为超级用户
	 */
	public function is_root()
	{
		return $this->admin->mg_id == 1;
	}

	/**
	 *	判断是否为超级管理员 || 所属平台为
	 */
	public function ManagerPlatform()
	{
		if(!$this->is_root()){
			if(!is_null($this->admin->platform_id)){
				return $this->admin->platform_id;
			}
			// 管理员平台为空
			return '';
		}
		// 超级管理员
		return '';
	}
	
	/**
	 *	根据管理员不同获取到不同的平台名称 自动判断是否为root
	 */
	public function GetPfNameByMg()
	{
		if(!$this->is_root()){
			$platform_id = $this->admin->platform_id;

			$platform_name = Platform::find($platform_id);
			
			return $platform_name->pf_name.PHP_EOL;
		}
		return '总控'.PHP_EOL;
	}

	/**
	 *	平台id
	 */
	public function GetPfId()
	{
		return $this->admin->platform_id;;
	}

	/**
	 *	导入 excel 平台id和彩金列表
	 */
	public function GetPfIdActivityList() 
	{
		// 未定义平台
		if(!is_null($this->admin->platform_id)){
			$platform = Platform::with('activity')->find($this->admin->platform_id);
			// 平台无活动
			
			if(count($platform->activity)){
				$new_arr = [];
				foreach ($platform->activity as $k => $v) {
					$new_arr[$k]['activity_id'] = $v->activity_id;
					$new_arr[$k]['activity_name'] = $v->activity_name;
					$new_arr[$k]['activity_status'] = $v->activity_status;
					$new_arr[$k]['activity_money'] = $v->activity_money;
				}
				$data = [
					'platform_id' => $this->admin->platform_id,
					'activity_arr' => $new_arr
				];
			}else{
				$data = [
					'platform_id' => $this->admin->platform_id,
					'activity_arr' => json_decode((new ActivityRepository())->GetActivityNameID(),true)
				];
			};
		}
		
		return json_decode(json_encode($data),true);
	}

	/**
	 *	根据不同的平台查询不同的表
	 */
	public function TableNameByPlatform()
	{
		
	}
	
} 
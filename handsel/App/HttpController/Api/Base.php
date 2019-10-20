<?php
namespace App\HttpController\Api;

use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Http\Request;
use EasySwoole\Core\Http\Response;
use App\Libs\Redis\Redis;

class Base extends Controller
{
	
	// controller 父类接口方法必须存在
    public function index() {}

    // redis 平台列表
    protected $platform_list = "platform_mark_list";

    // 平台和活动关系表
    protected $relation = "relation_";

    // 活动前缀
    protected $activity_pre = 'activity_';

    // 拦截器(权限相关)
    protected function onRequest($action):?bool
    {
        $this->response()->withHeader('Access-Control-Allow-Origin', '*');
        return true;
    }

	/**
     *  判断接口平台是否在允许的平台配置列表
     */
    public function VerifyAllowPlatform($params)
    {
    	if(empty($params['platform'])){
    		return false;
    	}
        $redis = new Redis();
        $platform = strtolower($params['platform']);
        $platform_info = json_decode($redis->get($platform));

        // 判断一下平台是否存在
        $exist = $redis->sismember($this->platform_list,$platform);
        var_dump('platform_exist-'.$exist);
        if(!$exist){
            throw new \Exception("{$platform_info->pf_name} 不存在,请联系超级管理员!");
        }

        // 判断一下平台状态
        var_dump('platform_status-'.$platform_info->platform_status);
        if($platform_info->platform_status == 2){
            throw new \Exception("{$platform_info->pf_name} 已经关闭了,请联系超级管理员!");
        }
    }

    /**
     *  彩金金额配置不符
     */
    public function HandselValueList($params)
    {
        if(empty($params['score'])){
            return false;
        }

        $redis = new Redis();
        $platform = strtolower($params['platform']);  // ezn
        $key = $this->relation.$platform;
        $relation = $redis->smembers($key);


        // 平台和活动对应关系
        foreach ($relation as $k => $v) {
            $activity = json_decode($redis->get($this->activity_pre.$v));
            if($activity->activity_money == $params['score']){
                if($activity->activity_status != 2){
                    var_dump($activity);
                    var_dump('activity_status-true');
                    return true;
                }
                var_dump('activity_status-false');
                return false;
            }
        }

        // 循环遍历金额没有相同的
        return false;
    }
}
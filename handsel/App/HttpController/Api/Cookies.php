<?php
namespace App\HttpController\Api;

use App\Libs\ClassArr;
use App\HttpController\Api\Base;

/**
 *	http://182.61.104.230:9501/api/cookies/run?platform=baijia
 * 	获取令牌指令
 */
class Cookies extends Base
{
	/**
	 *	每个平台cookie获取指令
	 * 	platform=baijia
	 */
	public function run()
	{
		$params = $this->request()->getRequestParam();

		if(empty($params['platform'])){
			return $this->writeJson(Status::CODE_BAD_REQUEST,'error','平台参数为空!');
		}

		// 判断接口平台是否在允许的平台配置列表
        if(!$this->VerifyAllowPlatform($params)){
            return $this->writeJson(Status::CODE_BAD_REQUEST,'error','接口平台不在允许的平台配置列表内或者传递参数为空!');
        }

        // 反射机制实例化一个对象
        $classObj = new ClassArr();
        $smsClassStat = $classObj->ClassStat();
        $obj = $classObj->InitClass(strtolower($params['platform']),$smsClassStat);

        return $obj->GetCookies();
	}
	
}
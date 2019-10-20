<?php 
namespace App\Libs;

/**
 * 反射原理 实例化一个未知的类
 */
class ClassArr
{
	public function ClassStat()
	{
		return [
			'sendsms' => '\App\Libs\Sms\RLYsms',
			'baijia' => '\App\Libs\AddPoint\BaiJia',
			'tianchao1' => '\App\Libs\AddPoint\TianChao1',
			'ezn' => '\App\Libs\AddPoint\Ezn'
		];
	}

	public function InitClass($type,$supportedClass,$params=[],$needInstance = true)
	{
		if(!array_key_exists($type, $supportedClass)){
			throw new \Exception("Failed to instantiate the class");
		}

		$className = $supportedClass[$type];
		return $needInstance ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
	}
}
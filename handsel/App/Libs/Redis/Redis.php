<?php 
namespace App\Libs\Redis;

use EasySwoole\Core\AbstractInterface\Singleton;

/**
 * redis 扩展类
 */
class Redis
{
	// 调用 esayswoole 单例模式 || 代码复用
	use Singleton;
	/**
	 *	redis对象
	 */
	protected $redis = '';

	/**
	 *	初始化连接redis
	 */
	public function __construct()
	{
		//	判断redis扩展是否存在
		if(!extension_loaded('Redis')){
			throw new \Exception("Redis 扩展不存在!");
		}
		
		$redisConfig = \Yaconf::get('redis');
		
		try {
			$this->redis = new \redis();
			$result = $this->redis->connect($redisConfig['host'],$redisConfig['port'],$redisConfig['timeout']);	
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage());
		}

		if($result === false){
			throw new \Exception("Redis 连接失败!");
		}
	}

	/**
	 *	集合判断是否拥有某个元素
	 */
	public function sismember($key,$value)
	{
		if(empty($key) || empty($value)){
			return 'key or value is empty';
		}

		return $this->redis->sismember($key,$value);
	}

	/**
	 *	获取到集合中所有元素
	 */
	public function smembers($key)
	{
		if(empty($key)){
			return 'key is empty';
		}

		return $this->redis->smembers($key);
	}

	/**
	 *	唯一id
	 */
	public function incr($key)
	{
		return $this->redis->incr($key);
	}

	/**
	 *	移除指定的集合元素
	 */
	public function Srem($key,$value)
	{
		if(empty($key) || empty($value)){
			return 'key or value is empty';
		}

		return $this->redis->Srem($key,$value);
	}
	/**
	 *	列表sadd
	 */
	public function Sadd($key,$value)
	{
		if(empty($key) || empty($value)){
			return 'key or value is empty';
		}

		return $this->redis->Sadd($key,$value);
	}

	/**
	 *	列表rpop
	 */
	public function Rpop($key)
	{
		if(empty($key)){
			return 'key is empty';
		}

		return $this->redis->Rpop($key);
	}
	/**
	 *	列表lpush
	 */
	public function Lpush($key,$value)
	{
		if(empty($key) || empty($value)){
			return 'key or value is empty';
		}

		return $this->redis->Lpush($key,$value);
	}
	/**
	 *	判断键是否存在
	 */
	public function exists($key)
	{
		if(empty($key)){
			return 'key is empty';
		}

		return !!($this->redis->exists($key));
	}

	/**
	 *	字符串类型 get
	 */
	public function get($key)
	{
		if(empty($key)){
			return 'key is empty';
		}

		return $this->redis->get($key);
	}
	/**
	 *	字符串类型 setex(set with expire)键秒值
	 */
	public function setex($key,$expire,$value)
	{
		if(empty($key) || empty($value)){
			return 'key or value is empty';
		}

		return $this->redis->setex($key,$expire,$value);
	}

	/**
	 *	字符串类型 set
	 */
	public function set($key,$value)
	{

		return $this->redis->set($key,$value);
	}

	/**
	 *	过期时间
	 */
	public function expire($key,$time)
	{
		return $this->redis->expire($key,$time);
	}

	/**
	 *	哈希 hget
	 */
	public function GetToken($k)
	{
		return $this->redis->hget($k,'token');
	}
}
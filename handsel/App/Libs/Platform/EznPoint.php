<?php 
namespace App\Libs\Platform;

use QL\QueryList;
use GuzzleHttp\Client;
use App\Libs\Redis\Redis;
use EasySwoole\Core\Component\Di;

/**
 * 模拟管理员操作接口
 */
class EznPoint
{
	/**
	 *	请求接口
	 */ 
	protected $domain = 'https://cvg.e9xz3mq8.xyz:43325';

	/**
	 *	实例化ql
	 */
	protected $ql = '';

	/**
	 *	管理员账号
	 */
	protected $admin = 'nuAhandsel1';

	/**
	 *	管理员密码
	 */
	protected $pwd = 'Qweasd123!';

	/**
	 *	令牌
	 */
	protected $token = '';

	/**
	 *	平台关键字
	 */
	protected $platform = '';

	/**
	 * 	实例化
	 */
	public function __construct($platform)
	{
		$this->platform = $platform;
		libxml_use_internal_errors(true);
		$this->ql = QueryList::getInstance();
	}

	/**
	 *	获取到token数组
	 */
	public function GetToken()
	{
		$redis = new Redis();
		$platform = json_decode($redis->get($this->platform),true);
		$arr = explode(',', $platform['token']);
		return $arr;
	}
	
	/**
	 *	查询会员接口(存在)
	 *	https://cvg.e9xz3mq8.xyz:43325/admin.php/gameplayer/index/index.html?_s=type=nickname|keyword=allen|channel=|reg_time=|login_time=|category=|usertype=|min_times=|max_times=|wincount=|lostcount=|min_gold=|max_gold=|min_recharge=|max_recharge=|min_exchange=|max_exchange=|min_waste=|max_waste=|is_export=&_o=type=eq|keyword=eq|channel=eq|reg_time=between%20time|login_time=between%20time|category=eq|usertype=eq|min_times=eq|max_times=eq|wincount=eq|lostcount=eq|min_gold=eq|max_gold=eq|min_recharge=eq|max_recharge=eq|min_exchange=eq|max_exchange=eq|min_waste=eq|max_waste=eq|is_export=eq
	 *	keyword: allen
	 */
	public function VerifyPlatformUser($username)
	{
		
		if(empty($username)){
			throw new \Exception("会员账号不得为空!");
		}
		$token = $this->GetToken();
		
		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => $token[0],
				'Cookie' => $token[1],
			]
		];

		$data = [
			'_s' => "type=nickname|keyword={$username}|channel=|reg_time=|login_time=|category=|usertype=|min_times=|max_times=|wincount=|lostcount=|min_gold=|max_gold=|min_recharge=|max_recharge=|min_exchange=|max_exchange=|min_waste=|max_waste=|is_export=",
			'_o' => 'type=eq|keyword=eq|channel=eq|reg_time=between time|login_time=between time|category=eq|usertype=eq|min_times=eq|max_times=eq|wincount=eq|lostcount=eq|min_gold=eq|max_gold=eq|min_recharge=eq|max_recharge=eq|min_exchange=eq|max_exchange=eq|min_waste=eq|max_waste=eq|is_export=eq',
		];
		
		$this->ql->get($this->domain . "/admin.php/gameplayer/index/index.html",$data,$opt);
		
		$res['username'] = $this->ql->find('#builder-table-main > tbody > tr > td:nth-child(4) > div')->text();
		
		$res['user_id'] = $this->ql->find('#builder-table-main > tbody > tr > td:nth-child(2) > div')->text();
		$res['status'] = !empty($res['username']) ? 1:0;
		$login = $this->ql->find('#main-container > div.content > div.row > div > div > div.block-header.bg-gray-lighter > h3')->text();
			
		// 判断状态
		if(!empty($res['username'])){
			$res['status'] = 1;
			$res['msg'] = "{$username}存在!";
		}else if(empty($res['username']) && $login != "游戏用户列表"){
			$res['status'] = 401;
			$res['msg'] = '令牌失效';
		}else if(empty($res['username']) && $login == "游戏用户列表"){
			$res['status'] = 0;
			$res['msg'] = "{$username}找不到";
		}

		
		//	401 => 会话失败 402 => ip限制 0 => 没有该会员
		if($res['status'] == 401){
			return ['code'=>401,'msg'=>$res['msg']];
		}

		if($res['status'] == 1){
			return ['code'=>1,'msg'=>$res['msg'],'data'=>json_encode($res)];
		}

		if($res['status'] == 0){
			return ['code'=>0,'msg'=>$res['msg']];
		}

 	}

	/**
	 *	添加彩金接口(动作)
	 *	https://cvg.e9xz3mq8.xyz:43325/admin.php/gameplayer/index/bonus/user_id/2732588.html?_pop=1
	 *	__token__: b29c632360412f05fda06a0f0791a001
	 *	user_id: 2732588
	 *  remark: 
	 *	gold: 0
	 */
	public function DoPlatformHandsel(array $data)
	{
		if(!is_array($data) || !count($data)){
			throw new \Exception('数据不合法');
		}

		$d = [
	 	 	'__token__'=> md5(time()),
		 	'user_id'=> $data['user_id'],
		 	'remark'=> $data['note'],
		 	'gold'=> $data['balance']
		];
		$token = $this->GetToken();
		
		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => $token[0],
				'Cookie' => $token[1],
			]
		];
		
		$this->ql->post($this->domain ."/admin.php/gameplayer/index/bonus/user_id/{$d['user_id']}.html",$d,$opt);

		$login = $this->ql->find('body > div.bg-white.pulldown > div > div > div > div > form > div.form-group.push-30-t > div > button')->text();

		if($login == "登 录"){
			$res['status'] = 401;
			$res['msg'] = "令牌失效";
		}else if($login != "登 录"){
			$res['status'] = 1;
			$res['msg'] = "{$data['username']}彩金成功";
		}
		$res['data'] = json_encode($data);
		//	401 => 会话失败 402 => ip限制 0 => 没有该会员
		
		if($res['status'] == 401){
			return ['code'=>0,'msg'=>$res['msg']];
		}

		// if($res['status'] == 0){
		// 	return ['code'=>0,'msg'=>$res['msg']];
		// }

		if($res['status'] == 1){
    		return ['code'=>1,'msg'=>$res['msg'],'data'=>$res['data']];
    	}
	}

	

} 
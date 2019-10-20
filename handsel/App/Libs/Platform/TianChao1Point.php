<?php 
namespace App\Libs\Platform;

use QL\QueryList;
use GuzzleHttp\Client;
use EasySwoole\Core\Component\Di;

/**
 * 玛雅平台
 */
class TianChao1Point
{
	/**
	 *	请求接口
	 */ 
	protected $domain = 'http://owner1-aka.ravown.com';

	/**
	 *	实例化ql
	 */
	protected $ql = '';

	/**
	 *	管理员账号
	 */
	protected $admin = 'tcAhandsel';

	/**
	 *	管理员密码
	 */
	protected $pwd = 'Qweasd123';

	/**
	 *	令牌
	 */
	protected $token = '';

	/**
	 *	初始化querylist
	 */
	public function __construct()
	{
		$this->ql = QueryList::getInstance();
		$redis   = Di::getInstance()->get('REDIS');
        $this->token = $redis->GetToken('tianchao1-token');
	}

	/**
	 *	查询会员接口
	 *	POST
	 *	接口地址:http://owner1-aka.ravown.com/qpsngw/api/user.profile.brief?_t=1570504942584
	 *	ac: getUserWithUtypeInfo
	 *	username: xiaoxin
	 */
	public function VerifyPlatformUser($username)
	{
		if(empty($username)){
			throw new \Exception("会员账号不得为空!");
		}

		var_dump('token:'.$this->token);
		// 生成随机数字
		$t = $this->GenerateString();
		$data = [
			"id"=> $t,
			"params"=> [
				"opsId"=> $this->token,
				"terminal"=> 7,
				"host"=> "qp.miao95.com",
				"userId"=> "",
				"userLoginId"=> $username,
				"withBalance"=> 1
			],
			"jsonrpc"=> "2.0",
			"method"=> "user.profile.brief"
		];

		$opt = [
			'timeout' => 15,
			'headers'=>[
		        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36',
		        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    		]	
		];
		$random = time();
		
		$this->ql->postJson($this->domain . '/qpsngw/api/user.profile.brief?_t='.$t,$data,$opt);
		$res = json_decode($this->ql->getHtml(),true);
		
		
		// var_dump('request:');
		// var_dump($res);
		
		// 会员存在
		if( $res['result'] != null){
			return ['code'=>1,'msg'=>"{$username}--存在",'data'=>json_encode($res['result'])];
		}

		// 会员不存在
		if( $res['result'] === null){
			return ['code'=>0,'msg'=>"{$username}--不存在"];
		}
		
		//	401 => 会话失败 402 => ip限制 0 => 没有该会员
		if($res['result'] == 0){
			return ['code'=>401,'msg'=>json_encode($res['error'])];
		}
	}

	/**
	 *	自动添加彩金
	 *	POST
	 *	接口地址:http://owner1-aka.ravown.com/qpsngw/api/sn.user.balance.sn.deposit?_t=1570506879310
	 *	
	 */
	public function DoPlatformHandsel(array $data)
	{
		// 生成随机数字
		$t = $this->GenerateString();
		var_dump('token:'.$this->token);
		//var_dump($data);
		$data = [
			"id"=> $t,
			"params"=> [
				"opsId"=> $this->token,
				"terminal"=> 7,
				"host"=> "qp.miao95.com",
				"operatorId"=> $data['username'],
				"accountItem"=> 10405,
				"isAudit"=> 0,
				"hasCommision"=> "1",
				"loginIds"=> [
					$data['username']
				],
				"discountFlag"=> true,
				"depositCoupon"=> $data['balance'],				// 彩金金额
				"depositCouponMemo" => $data['note'],		    // 备注
				"auditFlag"=> true,
				"couponAuditBetAmount"=> $data['balance']		// 稽核
			],
			"jsonrpc"=> "2.0",
			"method"=> "sn.user.balance.sn.deposit"
		];

		$opt = [
			'timeout' => 15,
			'headers'=>[
		        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/6.2.4094.1 Safari/537.36',
		        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    		]	
		];

		$this->ql->postJson($this->domain . '/qpsngw/api/sn.user.balance.sn.deposit?_t='.$t,$data,$opt);
		$res = json_decode($this->ql->getHtml(),true);
		// var_dump('request:');
		// var_dump($res);
		//	401 => 会话失败 402 => ip限制 0 => 没有该会员
		if($res['result'] == 0){
			return ['code'=>401,'msg'=>json_encode($res['error'])];
		}

		// 存款成功
		if($res['result']['success']){
			return ['code'=>1,'msg'=>$data['username'].'-存款成功','data'=>json_encode($res['result'])];
		}

		// 存款失败
		if($res['result']['fail']){
			return ['code'=>0,'msg'=>$data['username'].'-存款失败'];
		}

	}

	/**
	 *	生成随机数字
	 */
	public function GenerateString()
	{
		return time() . mt_rand(000,999);
	}

	/**
	 *	自动添加分数
	 *	
	 */
	public function DoPlatformPoint(array $data)
	{
		
	}
}
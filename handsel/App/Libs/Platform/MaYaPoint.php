<?php 
namespace App\Libs\Platform;

use QL\QueryList;
use GuzzleHttp\Client;

/**
 * 玛雅平台
 */
class MaYaPoint
{
	/**
	 *	请求接口
	 */ 
	protected $domain = 'https://asc4x.pandanb.com';

	/**
	 *	实例化ql
	 */
	protected $ql = '';

	/**
	 *	初始化querylist
	 */
	public function __construct()
	{
		$this->ql = QueryList::getInstance();
	}

	/**
	 *	查询会员接口
	 *	POST
	 *	接口地址:https://asc4x.pandanb.com/index.php/price/request.html
	 *	ac: getUserWithUtypeInfo
	 *	username: xiaoxin
	 */
	public function VerifyPlatformUser($username)
	{
		if(empty($username)){
			throw new \Exception("会员账号不得为空!");
		}

		$data = [
			'ac' => 'getUserWithUtypeInfo',
			'username' => $username
		];

		$opt = [
			'timeout' => 15,
			'headers' => [
				'Cookie' => 'PHPSESSID=sacatu4rllqkja9q3ilruoni96'
			]	
		];

		$this->ql->post($this->domain . '/index.php/price/request.html',$data,$opt);
		$json_data = json_decode($this->ql->getHtml());

		// 查询不到会员账号 1
		if($json_data->msg == 1){
			throw new \Exception($json_data->param);
		}
		// 查询到会员账号 0
		if($json_data->msg == 0){
			return ['status'=>true,'data'=>json_encode($json_data->data)];
		}
	

	}

	/**
	 *	自动添加彩金
	 *	POST
	 *	接口地址:https://asc4x.pandanb.com/index.php/price/request.html
	 *	post_accid: 15		// 查询会员接口 uid
	 *	post_price: 1		// 彩金金额
	 *	post_dama: 0		// 打码量存入开关
	 *	post_price_rq: 1	// 打码量金额
	 *	post_tui_status: 0	// 0 写入 1 取消
	 *	ac: postHumanicPay	// 接口方法
	 *	post_price_content: // 彩金备注
	 *	post_cun_content: 	
	 *	post_hui_content: 
	 *	pay_token: 10baee9efe146983b2299ac86e4a5c84		// 支付令牌
	 *	post_pay_type: 2	// 存款方式 : 优惠活动
	 */
	public function DoPlatformHandsel(array $data)
	{
		$data = [
			'post_accid'=> $data['uid'],		// 上个方法继承
			'post_price'=> $data['handsel'],	// 彩金
			'post_dama'=> 0,	
			'post_price_rq'=> $data['handsel'],	// 打码量金额	
			'post_tui_status'=> 0,	
			'ac'=> 'postHumanicPay',
			'post_price_content'=> $data['post_price_content'],	// 彩金备注
			'pay_token'=> $data['pay_token'],	// 上个方法继承
			'post_pay_type'=> 2					// 优惠存款
		];

		$opt = [
			'timeout' => 15,
			'headers' => [
				'Cookie' => 'PHPSESSID=sacatu4rllqkja9q3ilruoni96'
			]	
		];

		$this->ql->post($this->domain . '/index.php/price/request.html',$data,$opt);
		$json_data = json_decode($this->ql->getHtml());
		var_dump($json_data);

		// 非法操作! 您没有此权限或者入款授权已经超时,请尝试重刷页面后操作!
		if($json_data->msg == 2){
			throw new \Exception($json_data->param);
		}
		// 查询不到会员账号 1
		if($json_data->msg == 1){
			throw new \Exception($json_data->param);
		}
		// 查询到会员账号 0
		if($json_data->msg == 0){
			return ['status'=>true,'param'=>$json_data->param];
		}

	}

	/**
	 *	自动添加分数
	 *	
	 */
	public function DoPlatformPoint(array $data)
	{
		
	}
}
<?php 
namespace App\Libs\Platform;

use QL\QueryList;
use GuzzleHttp\Client;

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
	 * 	实例化
	 */
	public function __construct()
	{
		$this->ql = QueryList::getInstance();
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

		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => 'Basic azd0YW1nOiRmYD9YcHlURDZ6RTI0TD14LnZraXFBUFUtZ2g6dQ==',
				'Cookie' => 'PHPSESSID=22407ea040b00d13b4c5746973abce42',
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
	public function DoPlatformPoint(array $data)
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
		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => 'Basic azd0YW1nOiRmYD9YcHlURDZ6RTI0TD14LnZraXFBUFUtZ2g6dQ==',
				'Cookie' => 'PHPSESSID=22407ea040b00d13b4c5746973abce42',
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

	/**
     * 获取到二维码解析	
     * http://bjqpadmin1.com:1788/adminsystem/server/common/getVerify
     * get
     */
	public function GetAuthorization()
	{
		$data = $this->ParseCode();
		$postData = [
			'userAccount'=> 'BaiJiaAP',
			'userPassword'=> '7e977b4469cd807b6749b3205ef7d408',	// md5
			'validCode'=> $data['code']
		];

		$opt = [
			'headers' => [
				'Authorization' => $data['Authorization'],
			]
		];

		
		$this->ql->post($this->domain . '/adminsystem/server/adminuser/login',$postData,$opt);
		$res = json_decode($this->ql->getHtml(),true);
		if($res['status'] == 1){
			//Redis::set('bj-Authorization', $data['Authorization']);
			return ['code'=>'true','msg'=>'login is success'];
		}else{
			return ['code'=>'false','msg'=>'login is fail'];
		}
	}

	/**
	 *	
	 */

	public function heartbeat()
	{
		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => '5c0ea8e3-06f9-452d-9b84-d3ea30bb9610',
			]
		];
        $this->ql->get($this->domain . "/adminsystem/server/homepage/findByWithdrawCount",[],$opt);
        $res = json_decode($this->ql->getHtml(),true);

        if($res['status'] == 401){
        	return 'fail';
        }
        if($res['status'] == 1){
        	return 'success';
        }
	}
	/**
     * 获取到二维码解析	
     * http://bjqpadmin1.com:1788/adminsystem/server/common/getVerify
     * get
     */
	public function ParseCode()
	{
		//header('Content-type: image/jpg');
		$base64 = file_get_contents($this->domain . '/adminsystem/server/common/getVerify');
		$header = $http_response_header;
		$Authorization = explode(': ', $header[11])[1];
		
		// 把base64 转换为普通图片
		file_put_contents(public_path().'/code.png',base64_decode($base64));

		try {
          	//echo public_path().'/code.png';
    		$num = $this->juheApi(public_path().'/code.png');
          	//dd($num);
    		$code = json_decode($num,true)['result'];
          	//dd($num);
    	} catch (\Exception $e) {
    		app('log')->info('聚合数据服务器出错,时间: '.date('Y-m-d H:i:s',time()));
    	}

    	return ['code'=>$code,'Authorization'=>$Authorization];
		
	}

	/**
	 * 聚合api 返回json
	 */
    protected function juheApi($path_img)
    {
		header("Content-type:text/html;charset=utf-8");
		/* 请自行学习curl的知识，以下代码仅作引导之用，不可用于生产环境 */
		$ch = curl_init('http://op.juhe.cn/vercode/index');
		$cfile = curl_file_create($path_img, 'image/png', 'code.png');
		$data = array(
		  'key' => '56625805fc2df2cb997f73afebf564ed', //请替换成您自己的key
		  'codeType' => '4004', // 验证码类型代码，请在https://www.juhe.cn/docs/api/id/60/aid/352查询
		  'image' => $cfile
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		return ($response);
    }

} 
<?php 
namespace App\Libs\Platform;

use QL\QueryList;
use GuzzleHttp\Client;

/**
 * 模拟管理员操作接口
 */
class BaiJiaPoint
{
	/**
	 *	请求域名
	 */
	protected $domain = 'http://bjqpadmin1.com:1788';
	
	/**
	 *	
	 */
	protected $ql = '';

	/**
	 * 	实例化
	 */
	public function __construct()
	{
		$this->ql = QueryList::getInstance();
	}
	
	/**
	 *	查询会员接口(存在)
	 *	http://bjqpadmin1.com:1788/adminsystem/server/memberManager/findBalanceByUserAccount?userAccount=Kylin520
	 *	userAccount: Kylin520
	 */
	public function VerifyPlatformUser($username = '')
	{
		if(empty($username)){
			throw new \Exception("会员账号不得为空!");
		}

		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => '21b068a7-b95a-4687-a140-ad6b18d89ced',
			]
		];

		$data = [
			'userAccount' => $username,
		];

		$this->ql->get($this->domain . "/adminsystem/server/memberManager/findBalanceByUserAccount",$data,$opt);
		$res = json_decode($this->ql->getHtml(),true);
		
		//	401 => 会话失败 402 => ip限制 0 => 没有该会员
		if($res['status'] == 401 || $res['status'] == 402){
			throw new \Exception($res['msg']);
		}

		if($res['status'] == 1){
			return ['code'=>1,'msg'=>$res['msg'],'data'=>$res['data']];
		}

		if($res['status'] == 0){
			return ['code'=>0,'msg'=>$res['msg']];
		}

 	}

	/**
	 *	添加彩金接口(动作)
	 *	http://bjqpadmin1.com:1788/adminsystem/server/memberManager/updateHandsel
	 *	balance: "1"
	 *	damaMultiple: "1.00"
	 *	isCapital: "0"
	 *	note: "活动哦"
	 *	userAccount: "Kylin520"
	 */
	public function DoPlatformPoint(array $data)
	{
		if(!is_array($data) || !count($data)){
			throw new \Exception('数据不合法');
		}

		$data = [
	 	 	'balance'=> $data['balance'],
		 	'damaMultiple'=> "1.00",
		 	'isCapital'=> "0",
		 	'note'=> $data['note'],
		 	'userAccount'=> $data['username']
		];
		$opt = [
			'timeout' => 30,
			'headers' => [
				'Authorization' => '21b068a7-b95a-4687-a140-ad6b18d89ced',
			]
		];
		
		$this->ql->postJson($this->domain .'/adminsystem/server/memberManager/updateHandsel',$data,$opt);
		$res = json_decode($this->ql->getHtml(),true);

		//	401 => 会话失败 402 => ip限制 0 => 没有该会员
		if($res['status'] == 402){
			throw new \Exception($res['msg']);
		}

		if($res['status'] == 401){
			return ['code'=>0,'msg'=>$res['msg']];
		}

		if($res['status'] == 0){
			return ['code'=>0,'msg'=>$res['msg']];
		}

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
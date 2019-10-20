<?php
namespace App\HttpController;

use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Http\Message\Status;
use EasySwoole\Core\Component\Di;


class Index extends Controller
{
    function index()
    {
        $this->response()->write('hello world');
    }

    // 写入redis 
    public function writeRedis()
    {
        return Di::getInstance()->get('REDIS')->setex('15836020238test', 5000000 ,123456);
    }

    // 读redis 
    public function readRedis()
    {
        for ($i=0; $i < 1000; $i++) { 
         
            $redis = Di::getInstance()->get('REDIS')->get('15836020238test');
            var_dump($i.'-'.$redis);
        }
    }

    // 测试查询会员接口
    public function VerifyPlatformUser()
    {
    	try {
	    	$bj = new \App\Libs\Platform\EznPoint();
	    	$res = $bj->VerifyPlatformUser('allen');
    	} catch (\Exception $e) {
    		//return $this->response()->write($e->getMessage());
    		return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
    	}
    	return $this->response()->write(json_encode($res));
    }

    // 测试添加彩金接口
    public function DoPlatformHandsel()
    {
    	$data = [
    		'platform'=> 'tianchao1',
            'balance'=> '2.5',
            'note'=> '123123',
            'username'=> 'allen'
    	];


        // 809棋牌        
        $data = [
            'platform'=> 'ezn',
            'balance'=> '2.5',
            'note'=> '123123',
            'username'=> 'allen',
            'user_id'=> '2732588'
        ];

        
    	try {
	    	$bj = new \App\Libs\Platform\EznPoint();
	    	$res = $bj->DoPlatformHandsel($data);
    	} catch (\Exception $e) {
    		//return $this->response()->write($e->getMessage());
    		return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
    	}
    	return $this->response()->write(json_encode($res));
    }

    // 测试添加存款接口
    public function DoPlatformPoint()
    {
    	$data = [
    		'balance'=> "1",
	 		'damaMultiple'=> "1.00",
	 		'isCapital'=> "0",
	 		'note'=> "活动哦",
	 		'userAccount'=> "xiaoxin",
    	];

    	try {
	    	$bj = new \App\Libs\Platform\EznPoint();
	    	$res = $bj->DoPlatformPoint($data);
    	} catch (\Exception $e) {
    		//return $this->response()->write($e->getMessage());
    		return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
    	}
    	return $this->response()->write($res);

    }
}
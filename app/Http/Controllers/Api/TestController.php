<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

	// 彩金接口
	public function AutoHandsel($platform ='baijia',$money='1',$username='kylin520')
	{
        $data = [
            'platform'=> $platform,
            'balance'=> $money,
            'note'=> '',
            'username'=> $username
        ];

		$fp = new \App\Libs\Platform\BaiJiaPoint();

        try {
            $res = $fp->VerifyPlatformUser($data['username']);
            switch ($res['code']) {
                case '1':
                    $result = $this->DoPlatformPointTest($data);
                    if($result['code'] == 1){

                        return '存款成功!';
                    }else if($result['code'] == 0){

                        return '存款失败!';
                    }else if($result['code'] == 401){

                        return '会话失败';
                    }
                    return '会员存在!';
                case '0':

                    return '会员不存在!';
                case '401':

                    return '会话失败!';
            }

        } catch (\Exception $e) {
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

        return $res;
	}

    public function DoPlatformPointTest($data = [])
    {
        $bj = new \App\Libs\Platform\BaiJiaPoint();

        try {
            $res = $bj->DoPlatformPoint($data);
            switch ($res['code']) {
                case '1':
                    
                    //return '会员存款成功!';
                    return ['code'=>1];
                case '0':

                    //return '会员存款失败!';
                    return ['code'=>0];
                case '401':

                    //return '会话失败!';
                    return ['code'=>401];
                    
            }
        } catch (\Exception $e) {
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

    }

    public function Heartbeat()
    {
       $bj = new \App\Libs\Platform\BaiJiaPoint();

       return $bj->heartbeat();
    }

    public function VerifyPlatformUser()
    {
    	$bj = new \App\Libs\Platform\BaiJiaPoint();

    	try {
    		$res = $bj->VerifyPlatformUser('kylin520');
    	} catch (\Exception $e) {
            // 错误记录到数据库内

            //return ['code'=>0,'msg'=>$e->getMessage()];
    		return ['code'=>0];
    	}

    	if($res['code'] == 1){
            // 错误记录到数据库内
            //return ['code'=>1,'msg'=>$res['msg'],'data'=>$res['data']];
    		return ['code'=>1];
    	}else if($res['code'] == 0){
            // 错误记录到数据库内

            //return ['code'=>0,'msg'=>$res['msg']];
    		return ['code'=>0];
    	}else if($res['code'] == 401){

            return ['code'=>401];
        }
    }

    public function GetAuthorization()
    {
        $fp = new \App\Libs\Platform\BaiJiaPoint();
        $res = $fp->GetAuthorization();
        return $res;
    }

    // public function DoPlatformPoint()
    // {
    // 	$bj = new \App\Libs\Platform\BaiJiaPoint();

    // 	$data = [
    // 		'balance'=> '1',
		 	// 'note'=> '',
		 	// 'username'=> 'kylin520'
    // 	];

    // 	try {
    // 		$res = $bj->DoPlatformPoint($data);
    // 	} catch (\Exception $e) {
    // 		return ['code'=>0,'msg'=>$e->getMessage()];
    // 	}

    // 	if($res['code'] == 1){
    // 		return ['code'=>1,'msg'=>$res['msg'],'data'=>$res['data']];
    // 	}else if($res['code'] == 0){
    // 		return ['code'=>0,'msg'=>$res['msg']];
    // 	}
    // }
}

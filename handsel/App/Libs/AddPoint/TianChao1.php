<?php 
namespace App\Libs\AddPoint;


/**
 * 	天朝棋牌逻辑实现
 */
class TianChao1
{
	/**
	 *	平台名称
	 */
	protected $platform = 'tianchao1-';
	/**
	 *	自动添加彩金
	 */
	public function AutoHandsel($platform,$username,$phone,$money,$other=[])
	{
		$data = [
            'platform'=> $platform,
            'balance'=> $money,
            'note'=> $phone.'-'.$username.'-'.$money.'-handsel',
            'username'=> $username
        ];
        //var_dump('ok');
		$fp = new \App\Libs\Platform\TianChao1Point();
		//var_dump($fp);
        try {
            $res = $fp->VerifyPlatformUser($data['username']);
            //var_dump('VerifyPlatformUser');
            //var_dump($res);
            switch ($res['code']) {
                case '1':
                    $result = $this->DoPlatformPointTest($data);
                    // var_dump('DoPlatformPointTest:'.$result);
                    if($result['code'] == 1){
                    	// 返回true 
                        return ['code'=>1,'msg'=>"{$platform}-{$username}-{$phone}-{$money}-存款成功!"];
                    }else if($result['code'] == 0){
                    	// 返回false
                        return ['code'=>0,'msg'=>"{$platform}-{$username}-{$phone}-{$money}-存款失败!"];
                    }else if($result['code'] == 401){
                    	// 返回false
                        return ['code'=>0,'msg'=>"{$platform}-会话失败!"];
                    }

                    return ['code'=>0,'msg'=>'会员账号存款,不明原因送彩金失败!'];
                case '0':
                	// 返回 flase
                    return ['code'=>2,'msg'=>"{$platform}-{$username}-{$phone}-{$money}-会员不存在!"];
                case '401':
                	// 返回 false
                    return ['code'=>0,'msg'=>"{$platform}-会话失败!"];
            }

        } catch (\Exception $e) {
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

        return $res;
	}

	/**
	 *	平台添加彩金
	 */
	public function DoPlatformPointTest($data = [])
    {
        $bj = new \App\Libs\Platform\TianChao1Point();
        
        try {
            $res = $bj->DoPlatformHandsel($data);
            // var_dump('DoPlatformPointTest');
            // var_dump($res);
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
    
	/**
	 *	获取令牌(手动更新)
	 */
	public function GetCookies()
	{
		$fp = new \App\Libs\Platform\TianChao1Point();

        return $fp->GetAuthorization();
	}

	/**
	 *	心跳包,查询会员账号 (无)
	 *
	 */
	public function Heartbeat()
	{
		$fp = new \App\Libs\Platform\TianChao1Point();

		return $this->platform . $fp->Heartbeat(); 
	}
}
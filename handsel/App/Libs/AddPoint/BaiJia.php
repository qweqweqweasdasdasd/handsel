<?php 
namespace App\Libs\AddPoint;


/**
 * 	百家棋牌逻辑实现
 */
class BaiJia
{
	/**
	 *	平台名称
	 */
	protected $platform = 'baijia-';
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
        
		$fp = new \App\Libs\Platform\BaiJiaPoint();

        try {
            $res = $fp->VerifyPlatformUser($data['username']);
            switch ($res['code']) {
                case '1':
                    $result = $this->DoPlatformPointTest($data);
                    
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
    
	/**
	 *	获取令牌 
	 */
	public function GetCookies()
	{
		$fp = new \App\Libs\Platform\BaiJiaPoint();

        return $fp->GetAuthorization();
	}

	/**
	 *	心跳包,查询会员账号
	 *
	 */
	public function Heartbeat()
	{
		$fp = new \App\Libs\Platform\BaiJiaPoint();

		return $this->platform . $fp->Heartbeat(); 
	}
}
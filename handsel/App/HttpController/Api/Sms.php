<?php
namespace App\HttpController\Api;

use App\Model\Apply;
use App\Libs\ClassArr;
use App\HttpController\Api\Base;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Http\Message\Status;

/**
 *	发送短信
 *  POST
 *	接口:http://182.61.104.230:9501/api/sms/send
 *  platform=平台
 *  methodName=sendSms
 *  phone=手机号码
 */
class Sms extends Base
{
    protected $tempId = '254678';       //短信模板

    protected $validtime = '5';         //有效时间

    protected $expire = 86400;         //一天短信过期

    /**
     *  传递过来的参数
     */
    protected $params;

    /**
     *  发送短信 post
     *  参数:: platform || phone
     */
    public function send()
    {

        //$this->cors();
        $request = $this->request();
        $post = $request->getParsedBody();
        // $this->sendMessage($post['phone']);die();
        if(count($post)){
            $this->params = [
                'platform' => !empty($post['platform']) ? $post['platform'] : '',
                'methodName' => !empty($post['methodName']) ? $post['methodName'] : '',
                'phone' => !empty($post['phone']) ? intval($post['phone']) : '',
            ];
            
            // 判断接口平台是否在允许的平台配置列表
            try {
                $this->VerifyAllowPlatform($this->params);

            } catch (\Exception $e) {
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
            }

            // $this->params['platform_id'] = $this->getPlatformIndex($this->params['platform']);

            // // 手机号码是否在申请列表内(数据库)
            // if(! ($res = $this->findUseByPhone($this->params['phone'], $this->params['platform_id'])) ){
            //     return $this->writeJson(Status::CODE_BAD_REQUEST,'error','手机号码不在申请列表内!');
            // };

            // 数据验证 1, 所有字段不为空 2, 手机号码是否合法
            try {
                $this->VerifyRequestData($post);
        	    // 手机号码合法性查询 1, 手机号码在数据库内是否存在(参加活动没有权限) 
                $this->PhoneExistDatabase($post['phone']);
        	    // 会员账号合法性查询 1, 所属平台是否存在   (这个方法不提供)
                // $this->PlatformInUser($post['user']);
        	    // 发送短信业务
                $random_code = $this->sendMessage($post['phone']);
            } catch (\Exception $e) {
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
            }
            
            // 判断是否发送成功
            if($random_code){
                var_dump('sms-redis-w'.$this->params['phone'].'-'.$random_code);
                Di::getInstance()->get('REDIS')->setex($this->params['phone'], $this->expire ,$random_code);
                return $this->writeJson(Status::CODE_OK,'success','发送短信成功!');
            }else{
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error','发送短信失败!');
            }
 
        }
        return $this->writeJson(Status::CODE_BAD_REQUEST,'error','接口请求方式不对');
    }

    /**
     *  手机号码是否在申请列表内(数据库)
     */
    public function findUseByPhone($phone,$platform_id)
    {
        $redis   = Di::getInstance()->get('REDIS');
        $value   = $phone.'-'.$platform_id;

        $res = $redis->get($value);
        
        if(!$redis->exists($value)){
            $mark = (string)!!((new Apply($platform_id))->getOne('phone','platform_id',$phone,$platform_id));

            $res = $redis->set($value,$mark);
            $redis->expire($value,3600);        //1小时
            var_dump('走数据库');
            return $mark;
        }
        var_dump('走redis');
        return $res;
    }

    /**
     *  返回平台id`
     */
    public function getPlatformIndex($platform)
    {
        $platforms = \Yaconf::get('platform')['pf'];
        $pf = array_map('strtolower',$platforms);

        $index = array_search($platform,$pf);
        return $index;
    }

    /**
     *  发送短信业务 (反射机制实例化类)
     */
    public function sendMessage($phone = '')
    {
        $to = $phone;
        $random_code = mt_rand(111111,999999);
        $datas = array($random_code,$this->validtime);

        if(empty($phone)){
            throw new \Exception("phone is empty");
        }

        try {
            // $sms = new \App\Libs\Sms\RLYsms();
            // $res = $sms->sendTemplateSMS($to,$datas,$this->tempId);
            $classObj = new ClassArr();
            $smsClassStat = $classObj->ClassStat();
            $sms = $classObj->InitClass(strtolower($this->params['methodName']),$smsClassStat);
            $res = $sms->sendTemplateSMS($to,$datas,$this->tempId);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        //return $this->writeJson(Status::CODE_OK,'success',"{$random_code}");
        return $random_code;
    }

    /**
     *  post数据验证   1, 所有字段不为空 2, 手机号码是否合法
     */
    public function VerifyRequestData($post)
    {
        if(empty($post['platform']) || empty($post['phone']) || empty($post['methodName'])){
            throw new \Exception("platform or methodName or phone is empty");
        }

        if(!preg_match('/^1[3456789]\d{9}$/',$post['phone'])){
            throw new \Exception("手机格式不合法");  
        }

        
    }

    /**
     *  会员账号合法性查询 1, 所属平台是否存在
     */
    // public function PlatformInUser($user)
    // {
        
    // }

    /**
     *  手机合法性核对 (放到base控制器哩)
     *  1, 手机号码在数据库内是否存在(参加活动没有权限)
     */
    public function PhoneExistDatabase($phone)
    {
        // 手机号码是否在数据库内

        
    }

}

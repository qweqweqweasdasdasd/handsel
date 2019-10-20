<?php
namespace App\HttpController\Api;

use App\Model\Apply;
use App\Model\Handsel;
use App\HttpController\Api\Base;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;
use EasySwoole\Core\Http\Message\Status;
use App\Libs\Redis\Redis;

/**
 *	自动添加彩金
 *  BaiJia 平台
 *	接口:http://182.61.104.230:9501/api/score/AddScore
 *  POST
 *  添加到队列里
 *  platform! | score! | username | phone | smsCode!
 */
class Score extends Base
{
    /**
     *  传递过来的参数
     */
    protected $params;

    /**
     *  彩金列队键名
     */
    protected $handselKey = 'handsel-1';

    /**
     *  唯一id 键
     */
    protected $key = 'handsel_global_id';

    /**
     *  自动添加彩金
     */
    public function AddScore()
    {
        //$this->cors();
        $request = $this->request();
        $post = $request->getParsedBody();
       
        if(count($post)){
            $this->params = [
                'platform' => !empty($post['platform']) ? trim($post['platform']) : '',
                'score' => !empty($post['score']) ? trim($post['score']) : '',
                'username' => !empty($post['username']) ? trim($post['username']) : '',
                'phone' => !empty($post['phone']) ? trim($post['phone']) : '', 
                'smsCode' => !empty($post['smsCode']) ? trim($post['smsCode']) : ''
            ];
            
            // 判断接口平台是否在允许的平台配置列表
            try {
                $this->VerifyAllowPlatform($this->params);

            } catch (\Exception $e) {
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
            }
            
            // 判断申请彩金类型(金额)
            if(!$this->HandselValueList($this->params)){
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error','活动关闭或者活动金额不符要求!');
            }
            
            $this->params['platform_id'] = $this->getPlatformIndex($this->params['platform']);

            // 手机号码是否在申请列表内(数据库)
            if(! ($res = $this->findUseByPhone($this->params['phone'], $this->params['platform_id'])) ){
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error','手机号码不在申请列表内!');
            };
            
            // 判断短信验证码是的正确
            // 数据验证 1, 所有字段不为空 2, 手机号码是否合法
            try {
                $this->VerifySmsCode();
                $this->VerifyRequestData();
                
                // 检查是否已经在申请列表或者成功列表
                $this->CheckQueue();
                // 生成请求数据
                $this->CreateData();
            } catch (\Exception $e) {
                return $this->writeJson(Status::CODE_BAD_REQUEST,'error',$e->getMessage());
            }

            // 写入任务队列和报名集合
            $res = $this->WriteQueue();
            var_dump('写入队列状态:'.$res);
            return $this->writeJson(Status::CODE_OK,'success','平台正在处理中哦,请5分钟之后查询是否添加了彩金');
            
        }

        return $this->writeJson(Status::CODE_BAD_REQUEST,'error','接口请求方式不对');
    }

    /**
     *  手机号码是否在申请列表内(数据库)
     */
    public function findUseByPhone($phone,$platform_id)
    {
        //$redis   = Di::getInstance()->get('REDIS');
        $redis   = new Redis();
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
     * 生成请求数据
     */
    public function CreateData()
    {
        $redis = new Redis();
        $data = [
                'handsel_id' => $redis->incr($this->key),
                'phone' => $this->params['phone'],
                'type'  => $this->params['score'],
                'order_no' => $this->generateMark(),
                'username' => $this->params['username'],
                'platform_id' =>  $this->params['platform_id'],
                'status' => \Yaconf::get('handsel_status')['apply'],
                'created_at' => date('Y-m-d H:i:s',time())
        ];
        
        $data = (new Handsel($data['platform_id']))->create($data);
        
        return $data;
    }

    /**
     *  生成唯一标识
     */
    public function generateMark()
    {
        $str = $this->params['platform'].'-'.$this->params['username'].'-'.$this->params['score'].'-'.$this->params['phone'];

        return md5($str);
    }
    /**
     *  返回平台id`
     */
    public function getPlatformIndex($platform)
    {
        $redis = new Redis();
        $platform = json_decode($redis->get(strtolower($platform)));
        
        return (string)$platform->platform_id;
    }
    /**
     *  检查是否在申请列表内 && 彩金成功集合
     */
    public function CheckQueue()
    {
        //$redis   = Di::getInstance()->get('REDIS');
        $redis   = new Redis();
        $baseKey = $this->params['platform'].'-'.$this->params['score'];
        //$v   = $this->params['username'].'-'.$this->params['phone'];
        $v   = $this->params['platform'].'-'.$this->params['phone'];

        // 申请集合
        $exists = $redis->sismember($baseKey .'-apply',$v);
        var_dump('检查: '.$baseKey .'-apply-'.$exists);
        if($exists){
            throw new \Exception("您已经申请了彩金活动!");
        };
        
        // 彩金成功集合
        $exist  = $redis->sismember($baseKey .'-success',$v);
        var_dump('检查: '.$baseKey .'-success-'.$exist);
        if($exist){
            throw new \Exception("已经给您添加了彩金活动!");
        }

        // 彩金失败集合
        $exist  = $redis->sismember($baseKey .'-fail',$v);
        var_dump('检查: '.$baseKey .'-fail-'.$exist);
        if($exist){
            throw new \Exception("添加彩金失败咨询客服!");
        }
    }
    
    /**
     *  写入任务队列和报名集合
     *  handsel [baijia-username-11-15836020238];
     *  键:handsel 值: 平台-会员账号-彩金-手机号
     */
    public function WriteQueue()
    {
        $redis   = Di::getInstance()->get('REDIS');
        //$redis   = new Redis();

        $baseKey = $this->params['platform'].'-'.$this->params['score'];
        //$v   = $this->params['username'].'-'.$this->params['phone'];
        $v   = $this->params['platform'].'-'.$this->params['phone'];
        
        $value   = $this->params['platform'].'-'.$this->params['username'].'-'.$this->params['score'].'-'.$this->params['phone'];
        // 写入申请 [redis集合]
        
        $e = $redis->Sadd($baseKey .'-apply',$v);
        
        // 写入 [任务队列]
        
        $redis->Lpush('handsel-test',$value);
        return $redis->Lpush($this->handselKey,$value);

    }

    /** 
     *  检验发送短信是否合法 手机号-验证码
     */
    public function VerifySmsCode()
    {
        //$redis = Di::getInstance()->get('REDIS');
        $redis = new Redis();
        //var_dump('手机短信是否存在-'.$redis->exists($this->params['phone']).'手机号码:'.$this->params['phone'].'手机短信:'.$this->params['smsCode'].'redis手机短信:'.$redis->get($this->params['phone']));
        
        var_dump($redis);
        var_dump('redis-sms-code:'.$redis->get($this->params['phone']));
        var_dump('redis-sms-exit:'.$redis->exists($this->params['phone']));

        if(!$redis->exists($this->params['phone'])){
            throw new \Exception("短信验证码过期!");
        }
        
        //var_dump( .'-'. $this->params['smsCode']);
        
        if($redis->get($this->params['phone']) != $this->params['smsCode']){
            throw new \Exception("短信验证不对!");
        }
    }

    /**
     *  数据验证
     */ 
    public function VerifyRequestData()
    {   
        if(empty($this->params['platform']) || empty($this->params['score']) || empty($this->params['username']) || empty($this->params['phone']) || empty($this->params['smsCode']) ){
            throw new \Exception("params is empty");
        }

        if(!preg_match('/^1[3456789]\d{9}$/',$this->params['phone'])){
            throw new \Exception("手机格式不合法");  
        }
    }
}
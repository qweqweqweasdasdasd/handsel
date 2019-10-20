<?php 
namespace App\Libs\Process;

use EasySwoole\Core\Swoole\Process\AbstractProcess;
use EasySwoole\Core\Component\Logger;
use EasySwoole\Core\Component\Di;
use App\Libs\Redis\Redis;
use App\Model\Handsel;
use App\Libs\ClassArr;
use Swoole\Process;

/**
 *  消费者测试
 */
class ConsumerTest extends AbstractProcess
{
	private $isRun = false;

    protected $handselKey = 'handsel-1';

    public function run(Process $process)
    {
        // TODO: Implement run() method.
        /*
         * 举例，消费redis中的队列数据
         * 定时500ms检测有没有任务，有的话就while死循环执行
         */
        $this->addTick(500,function (){
            if(!$this->isRun){
                $this->isRun = true;
                //$redis = new \redis();//此处为伪代码，请自己建立连接或者维护redis连接
               	$redis = Di::getInstance()->get('REDIS');

                while (true){
                    try{
                        $task = $redis->Rpop($this->handselKey);	// ??出现过 去除 :0 数据启动了自动上分接口
                        $task_arr = explode('-', $task);            // ezn-allen01-1-15684698987
                        $falg = count($task_arr) == 4 ?true :false;     
                        
                        if($falg){
                            // 自动上分
                            var_dump('消费队列 '.$falg);
                            var_dump('定时器rpop取出数据:'.$this->getProcessName().'---'.$task);
							$this->Dowork($task);

                        }else{
                            break;
                        }
                   		
                    }catch (\Throwable $throwable){
                        break;
                    }
                }
                $this->isRun = false;
            }
            //var_dump($this->getProcessName().'-run');
        });
    }

    public function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }

    public function onReceive(string $str, ...$args)
    {
        // TODO: Implement onReceive() method.
    }

    /**
     *	请求模拟管理员接口
     */
    public function Dowork($task)
    {   
    	// 工作
        $data = explode('-', $task);
        //var_dump('Dowork'. $data);
        // 获取参数
        $platform = $data[0];
        $username = $data[1];
        $money    = $data[2];
        $phone    = $data[3];

        $platform_id = $this->getPlatformIndex($platform);
        var_dump($platform_id);
        // 组装baseKey 
        $baseKey = $platform . '-' . $money;
        //$value   = $username . '-' . $phone;
        $value   = $platform . '-' . $phone;

        // 利用反射机制赠送彩金
        $classObj = new ClassArr();
        $stat = $classObj->ClassStat();
        $pf = $classObj->InitClass(strtolower($platform),$stat);
        
        // 执行赠送彩金活动
        $res = $pf->AutoHandsel($platform,$username,$phone,$money);
        var_dump($res);
        $redis = Di::getInstance()->get('REDIS');
        $redis->Srem($baseKey .'-apply',$value);                    // 移除申请集合
        $order_no = $this->generateMark($platform,$username,$phone,$money);

        // 存款成功
        if($res['code'] == 1){
            // 请求接口ok 删除申请集合 添加成功集合
            var_dump('success-'.json_encode($res));
            $data = [
                'desc' => $res['msg'],
                'status' => \Yaconf::get('handsel_status')['success'],
            ];
            (new Handsel($platform_id))->update('order_no',$order_no,$data);

    		return $redis->Sadd($baseKey .'-success',$value);		// 添加成功集合 
    	}

        // 会员不存在导致失败
        if($res['code'] == 2){                                      
            var_dump('fail-'.json_encode($res));
            $data = [
                'desc' => $res['msg'],
                'status' => \Yaconf::get('handsel_status')['usererr'],
            ];
            // var_dump($data);
            (new Handsel($platform_id))->update('order_no',$order_no,$data);

            // 添加失败
            return $redis->Sadd($baseKey .'-fail',$value);
        }

        // 其他原因
        $data = [
                'desc' => $res['msg'],
                'status' => \Yaconf::get('handsel_status')['othererr'],
        ];

        (new Handsel($platform_id))->update('order_no',$order_no,$data);

        var_dump('fail-'.json_encode($res));                        
    	// 添加失败
    	return $redis->Sadd($baseKey .'-fail',$value);
    }


    /**
     *  生成唯一标识
     */
    public function generateMark($platform,$username,$phone,$money)
    {
        $str = $platform.'-'.$username.'-'.$money.'-'.$phone;

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
}
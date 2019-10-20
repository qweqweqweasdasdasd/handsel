<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use \EasySwoole\Core\AbstractInterface\EventInterface;
use EasySwoole\Core\Swoole\Process\ProcessManager;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use EasySwoole\Core\Swoole\Time\Timer;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
use EasySwoole\Core\Component\Di;
use App\Libs\Process\ConsumerTest;
use App\Libs\Redis\Redis;

Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');
        
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // TODO: Implement mainServerCreate() method.

        // 注入 redis 对象
        Di::getInstance()->set('REDIS',Redis::getInstance());

        // 启动三个进程
        $num = 5;
        for ($i = 0 ;$i < $num;$i++){
            ProcessManager::getInstance()->addProcess("consumer_test_{$i}",ConsumerTest::class);
        }

        // 连接数据库
        $dbConfig = \Yaconf::get('db');
        Di::getInstance()->set('MYSQL',\MysqliDb::class,Array (
            'host' => $dbConfig['host'],
            'username' => $dbConfig['username'],
            'password' => $dbConfig['password'],
            'db'=> $dbConfig['db'],
            'port' => $dbConfig['port'],
            'charset' => $dbConfig['charset'])
        );

        // 定时器要在启动之后启用否则会报错 // 平台心跳包
        // $register->add(EventRegister::onWorkerStart,function(\swoole_server $server,$workerId){
        //     if($workerId == 0){
        //         Timer::loop(5 * 60 * 1000,function() use($workerId){
        //             $bj = new \App\Libs\AddPoint\BaiJia();
        //             var_dump($bj->Heartbeat());
        //         });
        //     }
        // });
    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}
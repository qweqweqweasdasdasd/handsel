<?php

namespace App\Http\Controllers\Admin;

use App\Apply;
use Illuminate\Http\Request;
use App\Server\Pay\ExtendPay;
use App\Libs\Admin\AdminData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Repositories\CountRepository;
use App\Repositories\MerchantRepository;

class IndexController extends Controller
{
    /**
     * 角色仓库
     */
    protected $count;

    /**
     * 初始化仓库
     */
    public function __construct(CountRepository $count,MerchantRepository $merchant)
    {
        $this->count = $count;
        $this->merchant = $merchant;
    }

    /**
     * 域名直接跳转到登陆页面
     */
    public function jump()
    {
        return redirect()->route('login');
    }

    /**
     * 后台主页
     */
    public function index()
    {
        $GetPfNameByMg = (new AdminData())->GetPfNameByMg();
        //dump($GetPfNameByMg);      
        return view('admin.index.index',compact('GetPfNameByMg'));
    }

    /**
     * welcome
     */
    public function welcome()
    {
        $redis_success_keys = Redis::command('keys',['*-success']);
        if(!(new AdminData)->is_root()){
            $command = strtolower((new AdminData)->admin_mark()."-*-success");
            $redis_success_keys = Redis::command('keys' ,[$command] );
           
        };
        var_dump($redis_success_keys);
        // 百家导入数据总量
        $baijia_count = Apply::where(['platform_id'=>'1'])->count();

        $data = [];
        foreach ($redis_success_keys as $k => $v) {
            $arr = explode('-', $v);
            $platform = json_decode(Redis::get($arr[0]));
            
            $data[$v]['platform'][0] = '平台';    
            $data[$v]['platform'][1] = $platform->pf_name;

            $data[$v]['type'][0] = '彩金类型';    
            $data[$v]['type'][1] = $arr['1'].'元彩金活动';

            $data[$v]['apply'][0] = '申请人数';    
            $data[$v]['apply'][1] = $baijia_count.' 人'; 

            $data[$v]['success'][0] = '成功人数';    
            $data[$v]['success'][1] = Redis::scard($v).' 人'; 
           
            // $data[$v]['nuApply'][0] = '未申请人数';    
            // $data[$v]['nuApply'][1] = (string)(Redis::scard($v) - 5); 

            $data[$v]['money'][0] = '合计彩金';    
            $data[$v]['money'][1] = (string)(Redis::scard($v) * $arr['1']).' 元';
        }
        //var_dump($data);
        return view('admin.index.welcome',compact('data'));
    }

    /**
     *  平台对应汉字
     */
    public function platform_text($platform)
    {
        switch ($platform) {
            case 'baijia':
                return '百家棋牌';
            case '_database_baijia':
                return '百家棋牌';
            case 'tianchao1':
                return '天朝一棋牌';

        }
    }

    // 平台
    // 彩金 -- 参加人数 -- 到账人数 -- 未申请人数 -- 已送彩金金额
}

<?php

namespace App\Http\Controllers\Admin;

use Google2FA;
use App\Manager;
use App\Platform;
use App\ErrDesc\ApiErrDesc;
use Illuminate\Http\Request;
use App\Resphonse\JsonResphonse;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    /**
     * 二次验证开关
     */
    protected $gooleVerify = false;

    /**
     * 显示登录页面
     */
    public function login()
    {
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.index');
        }
        return view('admin.auth.login');
    }

    /**
     * 登录动作
     */
    public function DoLogin(AuthRequest $request)
    {
        // 管理员认证
        $user_password = $request->only(['mg_name','password']);
        if(!Auth::guard('admin')->attempt($user_password)){
            // 管理员认证失败
            return JsonResphonse::JsonData(ApiErrDesc::USER_AUTH_FAIL[0],ApiErrDesc::USER_AUTH_FAIL[1]);
        };
        
        // 检查管理状态 (中间件)
        if(!Auth::guard('admin')->user()->MgStatus()){
            // 管理员状态停用
            return JsonResphonse::JsonData(ApiErrDesc::USER_BAN_STATUS[0],ApiErrDesc::USER_BAN_STATUS[1]);
        };

        // 谷歌二次验证     
        if($this->gooleVerify){
            $secretKey = (Auth::guard('admin')->user()->google_token);
            
            if(!$secretKey){
                Auth::guard('admin')->logout();
                return JsonResphonse::JsonData(ApiErrDesc::GOOLE_BINDING_NO[0],ApiErrDesc::GOOLE_BINDING_NO[1]);
            }
            $verify = Google2FA::verifyKey($secretKey, $request->input('gooleToken'));
            if(!$verify){
                Auth::guard('admin')->logout();
                return JsonResphonse::JsonData(ApiErrDesc::GOOLE_VERIFY_FAIL[0],ApiErrDesc::GOOLE_VERIFY_FAIL[1]);
            }
        }

        // 检查费超级管理员 是否指定平台 平台是否关闭 
        try {
            $mg_id = Auth::guard('admin')->user()->mg_id;
            $this->PlatformStatus($mg_id);

        } catch (\Exception $e) {
            Auth::guard('admin')->logout();
            return JsonResphonse::JsonData(422,$e->getMessage());
        }
        // 记录登录次数,时间,ip
        $data = [
            'login_count' => ++Auth::guard('admin')->user()->login_count,
            'last_login_time' => date('Y-m-d H:i:s',time()),
            'last_login_ip' => $request->getClientIp()
        ];
        Auth::guard('admin')->user()->update($data);

        $resphonse = [
            'href' => '/admin/index'
        ];
        return JsonResphonse::ResphonseSuccess($resphonse);
    }

    /**
     *  检查费超级管理员 是否指定平台 平台是否关闭   
     */ 
    public function PlatformStatus($mg_id)
    {
        $manager = Manager::find($mg_id);

        // 非超级管理员
        if($manager->mg_id != 1){
            // 无平台数据
            if(!$manager->platform_id){
                throw new \Exception("没有给管理者: {$manager->mg_name} 设置所属平台");
            }

            // 平台关闭
            $platform = Platform::with('activity')->find($manager->platform_id);
            if($platform->platform_status == 2){
                throw new \Exception("平台: {$platform->pf_name} 已经关闭,请联系超级管理员!");
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        return redirect()->route('login');
    }
}

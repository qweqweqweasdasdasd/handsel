<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use Illuminate\Http\Request;
use App\Resphonse\JsonResphonse;
use App\Libs\Admin\PlatformRedis;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Repositories\PlatformRepository;
use App\Repositories\ActivityRepository;


class PlatformController extends Controller
{
    /**
     * 平台仓库
     */
    protected $platform;

    /**
     *
     */
    protected $activity;

    /**
     * 初始化仓库
     */
    public function __construct(PlatformRepository $platform,ActivityRepository $activity)
    {
        $this->platform = $platform;
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = [
            'keyword' => !empty($request->get('keyword'))? trim($request->get('keyword')) :'',
            'start' => !empty($request->get('start'))? trim($request->get('start')) :'',
            'end' => !empty($request->get('end'))? trim($request->get('end')) :''
        ];

        $pathInfo = $this->platform->getCurrentPathInfo();
        $platforms = $this->platform->GetPlatform($whereData);
        //dump($platforms);
        return view('admin.platform.index',compact('pathInfo','platforms','whereData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 参与的活动
        $activity = $this->activity->GetActivityNameID();
        //dump($activity);
        return view('admin.platform.create',compact('activity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'pf_name' => $request->get('pf_name'),
            'mark' => $request->get('mark'),
            'platform_status' => $request->get('platform_status'),
            'token' => $request->get('token')
        ];

        // 事务
        \DB::beginTransaction();
        try {
            $platform = $this->platform->PlatformSave($data);
            // 存储到 redis
            (new PlatformRedis)->store($platform,$request->get('activity_ids'));
            $platform->activity()->sync($request->get('activity_ids'));
            \DB::commit();
            return JsonResphonse::ResphonseSuccess();
        } catch (\Exception $e) {
            \DB::rollBack();
            return JsonResphonse::JsonData(ApiErrDesc::PLATFORM_SAVE_FAIL[0],ApiErrDesc::PLATFORM_SAVE_FAIL[1]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $status = $request->get('status');
        $mark = $this->platform->CommonFirst($id)->mark;
        
        if(!$this->platform->CommonUpdateStatus($id,$status)){
            return JsonResphonse::JsonData(ApiErrDesc::UPDATE_STATUS_FAIL[0],ApiErrDesc::UPDATE_STATUS_FAIL[1]);
        };
        // 存储到 redis
        (new PlatformRedis)->update_status($mark,$status);
        return JsonResphonse::ResphonseSuccess();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $platform = $this->platform->PlatformWithActivity($id);
        $activity = $this->activity->GetActivityNameID();
        $in_activity_arr = [];
        foreach ($platform->activity as $k => $v) {
            $in_activity_arr[] = $v->activity_id;
        }
        //dump($in_activity_arr);
        return view('admin.platform.edit',compact('platform','activity','in_activity_arr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            'pf_name' => $request->get('pf_name'),
            'mark' => $request->get('mark'),
            'platform_status' => $request->get('platform_status'),
            'token' => $request->get('token')
        ];
        // 事务
        \DB::beginTransaction();
        try {
            $platform = $this->platform->PlatformUpdate($id,$data);
            $platform->activity()->sync($request->get('activity_ids'));
            // 存储到 redis
            (new PlatformRedis)->store($platform,$request->get('activity_ids'));
            \DB::commit();
            return JsonResphonse::ResphonseSuccess();
        } catch (\Exception $e) {
            \DB::rollBack();
            return JsonResphonse::JsonData(ApiErrDesc::PLATFORM_UPDATE_FAIL[0],ApiErrDesc::PLATFORM_UPDATE_FAIL[1]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mark = $this->platform->CommonFirst($id)->mark;
        
        \DB::beginTransaction();
        try {
            // 删除管理员
            $this->platform->CommonDelete($id);
            // 删除管理员和角色关系
            $this->platform->PlatformActivityDelete($id);
            // 删除 redis
            (new PlatformRedis)->delete($mark);
            \DB::commit();
            return JsonResphonse::ResphonseSuccess();
        } catch (\Exception $th) {
            \DB::rollBack();
            return JsonResphonse::JsonData(ApiErrDesc::PLATFORM_DELETE_FAIL[0],ApiErrDesc::PLATFORM_DELETE_FAIL[1]);
        }
    }


    /**
     *  生成 redis 关系表
     */
    public function relation()
    {
        $table = Redis::keys('relation_*');
        foreach ($table as $k => $v) {
            Redis::del($table[$k]);
        }
        $key = 'relation_';
        $platform_activity = json_decode(\DB::table('platform_activity')->get(['platform_id','activity_id']),true);
        $GetPfNameId = ($this->platform->GetPfNameId());

        $new_arr = [];
        foreach ($GetPfNameId as $k => $v) {
            $new_arr[$v->platform_id] = strtolower($v->mark);    
        }
        
        foreach ($platform_activity as $k => $v) {
            //$v['platform_id'] = $new_arr[$v['platform_id']];
            Redis::sadd($key.$new_arr[$v['platform_id']],$v['activity_id']);
        }
        return JsonResphonse::ResphonseSuccess();
    }

}

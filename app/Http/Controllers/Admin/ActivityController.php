<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use Illuminate\Http\Request;
use App\Resphonse\JsonResphonse;
use App\Libs\Admin\ActivityRedis;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\PlatformRepository;

class ActivityController extends Controller
{
    /**
     * 角色仓库
     */
    protected $activity;

    /**
     *  平台仓库
     */
    protected $platform;

    /**
     * 初始化仓库
     */
    public function __construct(ActivityRepository $activity,PlatformRepository $platform)
    {
        $this->activity = $activity;
        $this->platform = $platform;
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

        $pathInfo = $this->activity->getCurrentPathInfo();
        $GetActivity = $this->activity->GetActivity($whereData);

        //dump($GetActivity);
        return view('admin.activity.index',compact('pathInfo','GetActivity','whereData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $GetPfNameId = $this->platform->GetPfNameId();
        //dump($GetPfNameId);
        return view('admin.activity.create',compact('GetPfNameId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {   
        $data = [
            'activity_name' => $request->get('activity_name'),
            'activity_money' => $request->get('activity_money'),
            'activity_status' => $request->get('activity_status'),
            'desc' => $request->get('desc')
        ];

        // 事务
        \DB::beginTransaction();
        try {
            $activity = $this->activity->ActivitySave($data);
            (new ActivityRedis)->store($activity);
            $activity->platform()->sync($request->get('platform_ids'));
            \DB::commit();
            return JsonResphonse::ResphonseSuccess();
        } catch (\Exception $e) {
            \DB::rollBack();
            return JsonResphonse::JsonData(ApiErrDesc::ACTIVITY_SAVE_FAIL[0],ApiErrDesc::ACTIVITY_SAVE_FAIL[1]);
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
        $activity_id = $this->activity->CommonFirst($id)->activity_id;

        if(!$this->activity->CommonUpdateStatus($id,$status)){
            return JsonResphonse::JsonData(ApiErrDesc::UPDATE_STATUS_FAIL[0],ApiErrDesc::UPDATE_STATUS_FAIL[1]);
        };

        (new ActivityRedis)->update_status($activity_id,$status);
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
        $GetPfNameId = $this->platform->GetPfNameId();
        $activity = $this->activity->ActivityFirstWithPlatform($id);
        $in_activity_arr = [];
        foreach ($activity->platform as $k => $v) {
            $in_activity_arr[] = $v->platform_id;
        }
        //dump($in_activity_arr);
        return view('admin.activity.edit',compact('GetPfNameId','activity','in_activity_arr'));
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
            'activity_name' => $request->get('activity_name'),
            'activity_money' => $request->get('activity_money'),
            'activity_status' => $request->get('activity_status'),
            'desc' => $request->get('desc')
        ];

        // 事务
        \DB::beginTransaction();
        try {
            $activity = $this->activity->ActivityUpdate($id,$data);
            (new ActivityRedis)->store($activity);
            $activity->platform()->sync($request->get('platform_ids'));
            \DB::commit();
            return JsonResphonse::ResphonseSuccess();
        } catch (\Exception $e) {
            \DB::rollBack();
            return JsonResphonse::JsonData(ApiErrDesc::ACTIVITY_UPDATE_FAIL[0],ApiErrDesc::ACTIVITY_UPDATE_FAIL[1]);
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
        $activity_id = $this->activity->CommonFirst($id)->activity_id;
        \DB::beginTransaction();
        try {
            // 删除管理员
            $this->activity->CommonDelete($id);
            (new ActivityRedis)->delete($activity_id);
            // 删除管理员和角色关系
            $this->activity->ActivityPlatformDelete($id);
            \DB::commit();
            return JsonResphonse::ResphonseSuccess();
        } catch (\Exception $th) {
            \DB::rollBack();
            return JsonResphonse::JsonData(ApiErrDesc::ACTIVITY_DELETED_FAIL[0],ApiErrDesc::ACTIVITY_DELETED_FAIL[1]);
        }
    }
}

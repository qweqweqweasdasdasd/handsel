<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Libs\Admin\AdminData;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\PlatformRepository;
use App\Repositories\ActivityRepository;

class UserController extends Controller
{
    /**
     *  用户仓库
     */
    protected $user;

    /**
     *  平台仓库
     */
    protected $platform;

    /**
     *  活动仓库
     */

    /**
     *  初始化仓库
     */
    public function __construct(UserRepository $user,PlatformRepository $platform,ActivityRepository $activity)
    {
        $this->user = $user;
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
        error_reporting(0);
        $whereData = [
            'phone' => !empty($request->get('phone'))? trim($request->get('phone')) :'',
            'start' => !empty($request->get('start'))? trim($request->get('start')) :'',
            'end' => !empty($request->get('end'))? trim($request->get('end')) :''
        ];

        $pathInfo = $this->user->getCurrentPathInfo();
        $applys = $this->user->GetApplys($whereData);
        $count = number_format($this->user->count($whereData));
        $GetPfIdActivityList = (new AdminData())->GetPfIdActivityList();

        //dd($GetPfIdActivityList);
        //dump($applys);
        // 平台名和平台id对应数组
        $platform_id_and_name_arr = [];

        foreach ($this->platform->GetPfNameId() as $k => $v) {
            $platform_id_and_name_arr[$v->platform_id] = $v->pf_name;
        }

        // 活动名和平台id对应数组
        $activity_id_and_name_arr = [];

        foreach ($this->activity->GetActivityNameID() as $k => $v) {
            $activity_id_and_name_arr[$v->activity_id] = $v->activity_name;
        }
        
        return view('admin.user.index',compact(
            'pathInfo',
            'applys',
            'whereData',
            'count',
            'platform_id_and_name_arr',
            'GetPfIdActivityList',
            'activity_id_and_name_arr'
        ));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}

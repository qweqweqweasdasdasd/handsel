<?php

namespace App\Http\Controllers\Admin;

use App\ErrDesc\ApiErrDesc;
use Illuminate\Http\Request;
use App\Resphonse\JsonResphonse;
use App\Http\Controllers\Controller;
use App\Repositories\HandselRepository;
use App\Repositories\PlatformRepository;

class HandselController extends Controller
{
    /**
     * 商户仓库
     */
    protected $handsel;

    /**
     * 平台仓库
     */
    protected $platform;

    /**
     * 初始化仓库
     */
    public function __construct(HandselRepository $handsel,PlatformRepository $platform)
    {
        $this->handsel = $handsel;
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
        
        $pathInfo = $this->handsel->getCurrentPathInfo();
        $GetHandsel = $this->handsel->GetHandsel($whereData);
        $count = number_format($this->handsel->count($whereData));
        // 平台名和平台id对应数组
        $platform_id_and_name_arr = [];

        foreach ($this->platform->GetPfNameId() as $k => $v) {
            $platform_id_and_name_arr[$v->platform_id] = $v->pf_name;
        }
        // dump($platform_id_and_name_arr);die();
        return view('admin.handsel.index',compact('pathInfo','GetHandsel','count','whereData','platform_id_and_name_arr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $handsel = $this->handsel->CommonFirst($id);
        
        return view('admin.handsel.edit',compact('handsel'));
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
        $handsel_id = $request->get('handsel_id');
        $data = [
            'desc' => $request->get('desc'),
        ];

        if(!$this->handsel->CommonUpdate($handsel_id,$data)){
             return JsonResphonse::JsonData(ApiErrDesc::UPDATE_HANDSEL_FAIL[0],ApiErrDesc::UPDATE_HANDSEL_FAIL[1]);
        };
        return JsonResphonse::ResphonseSuccess();
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

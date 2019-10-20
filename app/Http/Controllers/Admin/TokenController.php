<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ErrDesc\ApiErrDesc;
use App\Resphonse\JsonResphonse;
use App\Http\Requests\TokenRequest;
use App\Http\Controllers\Controller;
use App\Repositories\TokenRepository;
use Illuminate\Support\Facades\Redis;

class TokenController extends Controller
{

    /**
     * 下发订单仓库
     */
    protected $token;

    /**
     *  
     */    
    public function __construct(TokenRepository $token)
    {
        $this->token = $token;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pathInfo = $this->token->getCurrentPathInfo();
        
        $keys = Redis::keys('*-token');
        $pf_token = [];
        foreach ($keys as $k => $v) {
            $pf_token[$v] = $this->token->getPfToken($v);
        }
        
        //dump($pf_token);
        return view('admin.token.index',compact('pathInfo','pf_token'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.token.create',compact('create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TokenRequest $request)
    {
        $platform = $request->get('platform');
        $key = $platform .'-'.'token';
        $data = array_except($request->all(),['platform']);
        $data['status'] = 1; 
        
        if(!$this->token->TokenSaveWitchRedis($key,$data)){
            return JsonResphonse::JsonData(ApiErrDesc::TOEKN_SAVE_FAIL[0],ApiErrDesc::TOEKN_SAVE_FAIL[1]);
        };
        return JsonResphonse::ResphonseSuccess();
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
        $token = $this->token->getPfToken($id);
        $platform = explode('-', $id)[0];
        
        return view('admin.token.edit',compact('id','token','platform'));
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
        $key = $id;
        $data  = [
            'token' => $request->get('token'),
            'status' => 1
        ];

        if(!$this->token->TokenSaveWitchRedis($key,$data)){
            return JsonResphonse::JsonData(ApiErrDesc::TOEKN_UPDATE_FAIL[0],ApiErrDesc::TOEKN_UPDATE_FAIL[1]);
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

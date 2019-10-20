@extends('admin/common/layout')

@section('content')

<body>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body ">
                        <blockquote class="layui-elem-quote">欢迎管理员：
                            <span class="x-red">{{Auth::guard('admin')->user()->mg_name}}</span>！最后登录时间:{{Auth::guard('admin')->user()->last_login_time}}
                        </blockquote>
                    </div>
                </div>
            </div>   
            <div class="layui-col-md12">
                <div class="layui-card">

                    <div class="layui-card-header">数据统计</div> 
                    @foreach($data as $v)
                    <div class="layui-card-body ">
                        <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                            <li class="layui-col-md2 layui-col-xs5">
                                <a href="javascript:;" class="x-admin-backlog-body">
                                    <h3>{{$v['platform'][0]}}</h3>
                                    <p>
                                        <cite>{{$v['platform'][1]}}</cite></p>
                                </a>
                            </li>
                            <li class="layui-col-md2 layui-col-xs5">
                                <a href="javascript:;" onclick="location.reload()" class="x-admin-backlog-body">
                                    <h3>{{$v['type'][0]}}</h3>
                                    <p>
                                        <cite>{{$v['type'][1]}}</cite></p>
                                </a>
                            </li>
                            <li class="layui-col-md2 layui-col-xs5">
                                <a href="javascript:;" onclick="location.reload()" class="x-admin-backlog-body">
                                    <h3>{{$v['apply'][0]}}</h3>
                                    <p>
                                        <cite>{{$v['apply'][1]}}</cite></p>
                                </a>
                            </li>
                            <li class="layui-col-md2 layui-col-xs5">
                                <a href="javascript:;" onclick="location.reload()" class="x-admin-backlog-body">
                                    <h3>{{$v['success'][0]}}</h3>
                                    <p>
                                        <cite>{{$v['success'][1]}}</cite></p>
                                </a>
                            </li>
                            
                            <li class="layui-col-md2 layui-col-xs5 ">
                                <a href="javascript:;" onclick="location.reload()" class="x-admin-backlog-body">
                                    <h3>{{$v['money'][0]}}</h3>
                                    <p>
                                        <cite>{{$v['money'][1]}}</cite></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>  
            <style id="welcome_style"></style>
            
        </div>
    </div>
    </div>
</body>

@endsection


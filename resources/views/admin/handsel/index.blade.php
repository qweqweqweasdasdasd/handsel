@extends('admin/common/layout')

@section('content')

 <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="#">{{$pathInfo['module']}}</a>
        <a href="#">{{$pathInfo['cu']}}</a>
        <a>
          <cite>{{$pathInfo['method']}}</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
    </div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-body ">
                        <form class="layui-form layui-col-space5">
                            <div class="layui-inline layui-show-xs-block">
                                <input class="layui-input"  autocomplete="off" placeholder="开始日" name="start" id="start" value="{{$whereData['start']}}">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <input class="layui-input"  autocomplete="off" placeholder="截止日" name="end" id="end" value="{{$whereData['end']}}">
                            </div>
                            <!-- <div class="layui-input-inline layui-show-xs-block">
                                <select name="sms_status">
                                   
                                </select>
                            </div> -->
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="keyword"  placeholder="请输入手机号码或者会员账号" autocomplete="off" class="layui-input" style="width:250px;" value="{{$whereData['keyword']}}">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>
                    </div> 
                    <div class="layui-card-header">
                        
                        <span class="layui-btn layui-btn-normal" style="float:right">共计:{{$count}}</span>
                    </div>
                    <div class="layui-card-body layui-table-body layui-table-main">
                        <table class="layui-table layui-form">
                            <thead>
                              <tr>
                                
                                <th>ID</th>
                                <th>手机号</th>
                                <th>会员账号</th>
                                <th>彩金类型</th>
                                <th>状态</th>
                                <th>所属平台</th>
                                <th>备注</th>
                                <th>创建时间</th>
                                <th>操作</th>
                              </tr>
                            </thead>
                            <tbody>
                             	@foreach($GetHandsel as $v)
                             	 <tr>
	                                <td>{{$v->handsel_id}}</td>
	                                <td>{{$v->phone}}</td>
	                                <td>{{$v->username}}</td>
	                                <td>{!!Handsel_type($v->type)!!}</td>
	                                <td>{!!handsel_show_status($v->status)!!}</td>
	                                <td><span class="layui-badge layui-bg-blue">{{ $platform_id_and_name_arr[$v->platform_id] }}</span></td>
	                                <td>{{$v->desc}}</td>  
	                                <td>{{$v->created_at}}</td>  
	                                <td class="td-manage">
		                               <a title="编辑"  onclick="xadmin.open('编辑','/admin/handsel/{{$v->handsel_id}}/edit',600,800,1)" href="javascript:;">
	                                    <i class="layui-icon">&#xe642;</i>
	                                	</a>
	                                </td>
	                              </tr>
                             	@endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-card-body">
                        <div class="page">
                            {{ $GetHandsel->appends(['keyword'=>$whereData['keyword'],'end'=>$whereData['end'],'start'=>$whereData['start']])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>

@endsection

@section('my-js')
<script>
    layui.use(['form','jquery','upload','laydate'],function(){
        var upload = layui.upload;
        var form = layui.form;
        var $ = layui.jquery;
        var laydate = layui.laydate;


        // 执行一个laydate实例
        laydate.render({
            elem:'#start',
            type: 'datetime'
        });

        laydate.render({
            elem:'#end',
            type: 'datetime'
        });

        //执行实例
        var uploadInst = upload.render({
            elem: '#csv' //绑定元素
            ,url: '/server/upload/import' //上传接口
            ,accept:'file'
            ,method:'post'
            ,done: function(res){
              if(res.code == 422){
                layer.msg(res.msg,{icon:5})
              }
              if(res.code == 1){
                layer.msg(res.msg,{icon:6})
              }
            }
            ,error: function(){
              //请求异常回调
            }
        });

    
    })

   

</script>
@endsection


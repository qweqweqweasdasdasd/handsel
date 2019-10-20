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
                            <div class="layui-input-inline layui-show-xs-block">
                                <input class="layui-input" placeholder="开始日" name="start" id="start" value="{{$whereData['start']}}"></div>
                            <div class="layui-input-inline layui-show-xs-block">
                                <input class="layui-input" placeholder="截止日" name="end" id="end" value="{{$whereData['end']}}"></div>
                            
                            
                            <div class="layui-input-inline layui-show-xs-block">
                                <input type="text" name="keyword" placeholder="请输入平台名称" autocomplete="off" class="layui-input" value="{{$whereData['keyword']}}" style="width:250px;"></div>
                            <div class="layui-input-inline layui-show-xs-block">
                                <button class="layui-btn" lay-submit="" lay-filter="sreach" >
                                    <i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>
                    </div>
                    <div class="layui-card-header">
                        <button class="layui-btn" onclick="xadmin.open('添加平台','/admin/platform/create',600,800,1)"><i class="layui-icon"></i>添加平台</button>
                        <button class="layui-btn" onclick="send()"><i class="layui-icon">&#xe609;</i>手动生成关系表</button>
                    </div>
                    <div class="layui-card-body layui-table-body layui-table-main">
                        <table class="layui-table layui-form">
                            <thead>
                              <tr> 
                              	<th>ID</th>  
                                <th>平台名称</th>
                                <th>标记</th>
                                <th>参加活动</th>
                                <th>令牌</th>
                                <th>状态</th>
                                <th>操作</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach($platforms as $v)
                               <tr>
                               	 <td>{{$v->platform_id}}</td>
                               	 <td>{{$v->pf_name}}</td>
                                 <td>{{$v->mark}}</td>
                               	 <td>
                                    @foreach($v->activity as $vv)
                                     {!! platform_status_colour($vv->activity_status,$vv->activity_name) !!}
                                    @endforeach
                                 </td>
                               	 <td>{{$v->token}}</td>
                               	 <td>{!! common_switch_status($v->platform_status) !!}</td>
                               	 <td>
                                    <a title="编辑"  onclick="xadmin.open('编辑','/admin/platform/{{$v->platform_id}}/edit',600,800,1)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    <a title="删除" onclick="del(this,'{{$v->platform_id}}')" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                    </a>
                                 </td>
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-card-body ">
                        <div class="page">
                            {{ $platforms->appends(['start' => $whereData['start'],'end' => $whereData['end'],'keyword' => $whereData['keyword']])->links() }}
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

        //监听指定开关
        // form.on('switch(switchTest)', function(data){
        //     layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
        //     offset: '6px'
        //     });
        //     layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
        // });

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

        // 切换状态
        $('.switch-status').on('click',function(){
            var status = $(this).attr('data-status');
            var id = $(this).parents('tr').find('td:eq(0)').html();
            //debugger;
            // ajax
            $.ajax({
                url:'/admin/platform/'+id,
                data:{status:status},
                type:'get',
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                success:function(res){
                    if(res.code == '1'){
                        window.location.reload(); 
                    }
                    if(res.code == '10000'){
                        layer.msg(res.msg,{icon:5})
                    }
                }
            })
            
        })

        // 监听指定是否验证开关
        // form.on('switch(switchVerify)',function(data){
        //     layer.msg('状态:'+ (this.checked ? ' 验证' : ' 不验证'),{
        //         offset :'6px'
        //     });
        // })
    
    })

    function send(){
        $.ajax({
            url:'/admin/create/relation',
            data:'',
            dataType:'json',
            type:'POST',
            headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
            },
            success:function(res){
                if(res.code == 1){
                    layer.msg('发送了命令');
                }
                
            }
        });
    }

    function del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $.ajax({
                url:'/admin/platform/'+id,
                data:'',
                dataType:'json',
                type:'DELETE',
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                success:function(res){
                    if(res.code == 1){
                        $(obj).parents('tr').remove();
                        layer.msg('已删除',{icon:1,time:1000});
                    }
                    if(res.code == '6502'){
                        layer.msg(res.msg,{icon:5})
                    }
                }
            })
        });
    }

</script>
@endsection


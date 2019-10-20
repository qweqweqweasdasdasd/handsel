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
                            <div class="layui-input-inline layui-show-xs-block">
                                <select name="sms_status">
                                    <option value="">邀请状态</option>
                                    <option value="1" @if($whereData['sms_status'] == 1) selected @endif>成功</option>
                                    <option value="2" @if($whereData['sms_status'] == 2) selected @endif>失败</option>
                                </select>
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="phone"  placeholder="请输入手机号" autocomplete="off" class="layui-input" value="{{$whereData['phone']}}" style="width:250px;">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>
                    </div>
                    <div class="layui-card-header">
                        <!-- <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button> -->
                        <button class="layui-btn" onclick="xadmin.open('人工短信邀请用户','/admin/sms/invite',600,400)"><i class="layui-icon">&#xe609;</i>人工短信邀请用户</button>
                    </div>
                    <div class="layui-card-body layui-table-body layui-table-main">
                        <table class="layui-table layui-form">
                            <thead>
                              <tr>
                                
                                <th>ID</th>
                                <th>手机号</th>
                                <th>验证码</th>
                                <th>短信内容</th>
                                <th>类型</th>
                                <th>状态</th>
                                <th>备注</th>
                                <th>操作者</th></tr>
                            </thead>
                            <tbody>
                              @foreach($smsLogs as $d)
                              <tr>
                               
                                <td>{{$d['sms_log_id']}}</td>
                                <td>{{$d['phone']}}</td>
                                <td>{{$d['code']}}</td>
                                <td>{{$d['content']}}</td>
                                <td>{{$d['type']}}</td>
                                <td>{!! common_status($d['sms_status']) !!}</td>
                                <td>{{$d['desc']}}</td>
                                <td>{{$d['handlers']}}</td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-card-body ">
                        <div class="page">
                            {{ $smsLogs->appends(['start' => $whereData['start'],'end' => $whereData['end'],'phone' => $whereData['phone']])->links() }}
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
    layui.use(['form','jquery','laydate'],function(){
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

        // 监听指定是否显示开关
        form.on('switch(switch)',function(data){
            var param = $(this).attr('data');
            var d = this.checked ? '1' : '2';
            var id = $(this).parents('tr').find('td:eq(0)').html();
            $.ajax({
                url:'/admin/rule/switch/' + param,
                data:{d:d,id:id},
                dataType:'json',
                type:'post',
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                success:function(res){
                    if(res.code == 1){
                        //debugger
                        if(res.data == 'is_verify'){
                            layer.msg('状态:'+ (this.checked ? ' 验证' : ' 不验证'),{
                                offset :'6px'
                            }); 
                        }
                        if(res.data == 'is_show'){
                            layer.msg('状态:'+ (this.checked ? ' 显示' : ' 不显示'),{
                                offset :'6px'
                            });
                        }
                    }
                    if(res.code == '5003'){
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

    function rule_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //发异步删除数据
            $.ajax({
                url:'/admin/rule/'+id,
                data:'',
                dataType:'json',
                type:'DELETE',
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                success:function(res){
                    if(res.code == 1){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                    if(res.code == '5001'){
                        layer.msg(res.msg,{icon:5})
                    }
                }
            })
        });
    }

</script>
@endsection


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
                            
                            <div class="layui-inline layui-show-xs-block">
                                <input type="text" name="phone"  placeholder="请输入用户名" autocomplete="off" class="layui-input" style="width:250px;" value="{{$whereData['phone']}}">
                            </div>
                            <div class="layui-inline layui-show-xs-block">
                                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                            </div>
                        </form>
                    </div> 
                    <div class="layui-card-header">
                        @if( !(new App\Libs\Admin\AdminData())->is_root() )
                        <input type="hidden" name="platform_id" value="{{$GetPfIdActivityList['platform_id']}}">
                        <div class="layui-input-inline layui-show-xs-block">
                            <select name="activity_id" style="height: 30px; width: 150px;" id="activity_id">
                                @foreach($GetPfIdActivityList['activity_arr'] as $v)
                                <option value="{{$v['activity_id']}}" @if($v['activity_status'] == 2) disabled @endif>&nbsp;{{$v['activity_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="layui-btn" id="csv">
                          <i class="layui-icon">&#xe67c;</i>导入csv数据
                        </button>
                        &nbsp;&nbsp;导入之前选择平台, excel格式: 手机号 
                        @endif
                        <span class="layui-btn layui-btn-normal" style="float:right">共计: {{$count}}</span>
                    </div>
                    <div class="layui-card-body layui-table-body layui-table-main">
                        <table class="layui-table layui-form">
                            <thead>
                              <tr>   
                                <th>ID</th>
                                <th>手机号</th>
                                <th>所属平台</th>
                                <th>所属活动</th>
                                <th>创建时间</th>
                               </tr>
                            </thead>
                            <tbody>
                              @foreach($applys as $a)
                              <tr>  
                                <td>{{$a->apply_id}}</td>
                                <td>{{$a->phone}}</td>
                                <td><span class="layui-badge layui-bg-blue">{{$platform_id_and_name_arr[$a->platform_id]}}</span></td>
                                <td><span class="layui-badge layui-bg-blue">{{$activity_id_and_name_arr[$a->activity_id]}}</span></td>
                                <td>{{$a->created_at}}</td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="layui-card-body ">
                        <div class="page">
                            {{ $applys->appends(['phone'=>$whereData['phone'],'end'=>$whereData['end'],'start'=>$whereData['start']])->links() }}
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
            ,before: function(obj){
                var platform_id = $('input[name="platform_id"]').val();
                var activity_id = $('#activity_id').find('option:selected').val();
                this.data = {'platform_id':platform_id,'activity_id':activity_id};
                
            }
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


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
                    <div class="layui-card-header">
                        <button class="layui-btn" onclick="xadmin.open('添加令牌','/admin/token/create',600,400,1)"><i class="layui-icon"></i>添加</button>
                    </div>
                    <div class="layui-card-body layui-table-body layui-table-main">
                        <table class="layui-table layui-form">
                            <thead>
                              <tr>   
                                <th>平台名称</th>
                                <th>令牌</th>
                                
                                <th>操作</th>
                               </tr>
                            </thead>
                            <tbody>
                                @foreach($pf_token as $k => $v)
                             	<tr>
                             		<td>{{$k}}</td>
                             		<td>{{$v[0]}}</td>
                             		
                             		<td>
                                        <a title="编辑"  onclick="xadmin.open('编辑','/admin/token/{{$k}}/edit',600,800,1)" href="javascript:;">
                                            <i class="layui-icon">&#xe642;</i>
                                        </a>     
                                    </td>
                             	</tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    'X-CSRF-TOKEN':"{csrf_token()}"
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
                    'X-CSRF-TOKEN':"{csrf_token()}"
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


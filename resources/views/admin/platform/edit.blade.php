@extends('admin/common/layout')

@section('content')

<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<div class="layui-form-item layui-form-text">
                    <input type="hidden" name="platform_id" value="{{$platform->platform_id}}">
	                <label for="token" class="layui-form-label">
	                    <span class="x-red">*</span>平台名称</label>
	                </label>
	                <div class="layui-input-block">
	                     <input type="text" id="pf_name" name="pf_name" value="{{$platform->pf_name}}" autocomplete="off" class="layui-input" placeholder="请输入平台名称">
	                </div>
	            </div>
	            <div class="layui-form-item layui-form-text">
	                <label for="token" class="layui-form-label">
	                    <span class="x-red">*</span>平台标记</label>
	                </label>
	                <div class="layui-input-block">
	                     <input type="text" id="mark" name="mark" value="{{$platform->mark}}" autocomplete="off" class="layui-input" placeholder="请输入平台标记">
	                </div>
	            </div>
                <div class="layui-form-item">
                       <label class="layui-form-label"><span class="x-red">*</span>参与活动</label>
                       <div class="layui-input-block">
                        @foreach($activity as $v)
                         <input type="checkbox" name="activity_ids[]" lay-skin="primary" title="{{$v->activity_name}}" @if($v->activity_status == 2) disabled @endif value="{{$v->activity_id}}" @if(in_array($v->activity_id,$in_activity_arr)) checked @endif>
                        @endforeach
                       </div>
                </div>
                <div class="layui-form-item">
                       <label class="layui-form-label"><span class="x-red">*</span>状态</label>
					    <div class="layui-input-block">
					      <input type="radio" name="platform_status" title="开启" value="1" @if($platform->platform_status == "1") checked @endif>
					      <input type="radio" name="platform_status" title="关闭" value="2" @if($platform->platform_status == "2") checked @endif>
					    </div>
                </div>
                <div class="layui-form-item layui-form-text">
	                <label for="token" class="layui-form-label">
	                    <span class="x-red">*</span>令牌</label>
	                </label>
	                <div class="layui-input-block">
	                    <textarea placeholder="请输入平台管理后台令牌" id="token" name="token" class="layui-textarea">{{$platform->token}}</textarea>
	                </div>
	            </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="update" lay-submit="">更新</button></div>
            </form>
        </div>
    </div>
</body>

@endsection

@section('my-js')
<script>
    layui.use(['form','layer'],function(){
        var $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;

        // 监听提交
        form.on('submit(update)',function(data){
            var platform_id = $('input[name="platform_id"]').val();

            console.log(data.field);
            //ajax
            $.ajax({
                url:'/admin/platform/'+platform_id,
                data:data.field,
                dataType:'json',
                type:'PATCH',
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                success:function(res){
                    if(res.code == '1'){
                        layer.alert(res.msg,{icon:6},function(){
                            window.parent.location.reload();        
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        })
                    }
                    if(res.code == '6501'){
                        layer.msg(res.msg,{icon:5})
                    }
                    if(res.code == '422'){
                        layer.msg(res.msg);
                    }

                }
            })
            return false;
        })

        // 
    })

    // 切换状态
    $('.switch-status').on('click',function(){
        var status = $(this).attr('data-status');
        var id = $(this).parents('tr').find('td:eq(0)').html();
        //debugger;
        // ajax
        $.ajax({
            url:'/admin/manager/'+id,
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
</script>
@endsection


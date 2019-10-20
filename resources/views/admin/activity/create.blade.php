@extends('admin/common/layout')

@section('content')

<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<div class="layui-form-item layui-form-text">
	                <label for="activity_name" class="layui-form-label">
	                    <span class="x-red">*</span>活动名</label>
	                </label>
	                <div class="layui-input-block">
	                     <input type="text" id="activity_name" name="activity_name"  autocomplete="off" class="layui-input" placeholder="请输入活动名称">
	                </div>
	            </div>
	            <div class="layui-form-item layui-form-text">
	                <label for="activity_money" class="layui-form-label">
	                    <span class="x-red">*</span>彩金金额</label>
	                </label>
	                <div class="layui-input-block">
	                     <input type="text" id="activity_money" name="activity_money"  autocomplete="off" class="layui-input" placeholder="请输入彩金金额">
	                </div>
	            </div>
                <div class="layui-form-item">
                       <label class="layui-form-label"><span class="x-red">*</span>参与平台</label>
					   <div class="layui-input-block">
					   	 @foreach($GetPfNameId as $v)
                         <input type="checkbox" name="platform_ids[]" lay-skin="primary" title="{{$v->pf_name}}"  @if($v->platform_status == 2) disabled @endif value="{{$v->platform_id}}" >
                         @endforeach
                       </div>
                </div>
                <div class="layui-form-item">
                       <label class="layui-form-label"><span class="x-red">*</span>状态</label>
					    <div class="layui-input-block">
					      <input type="radio" name="activity_status" title="开启" value="1" checked>
					      <input type="radio" name="activity_status" title="关闭" value="2">
					    </div>
                </div>
                <div class="layui-form-item layui-form-text">
	                <label for="desc" class="layui-form-label">
	                    <span class="x-red">*</span>活动描述</label>
	                </label>
	                <div class="layui-input-block">
	                    <textarea placeholder="请输入活动具体描述" id="desc" name="desc" class="layui-textarea"></textarea>
	                </div>
	            </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
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
        form.on('submit(add)',function(data){
            console.log(data.field);
            //ajax
            $.ajax({
                url:'/admin/activity',
                data:data.field,
                dataType:'json',
                type:'post',
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
                    if(res.code == '7500'){
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
</script>
@endsection


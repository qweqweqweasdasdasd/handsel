@extends('admin/common/layout')

@section('content')

<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<input type="hidden" name="id" value="{{$id}}">
                <div class="layui-form-item">
                        <label for="username" class="layui-form-label">
                            <span class="x-red">*</span>平台名称</label>
                        <div class="layui-input-block">
                            <select id="platform" name="platform" class="valid">
                                <option value="tianchao1" @if($platform == 'tianchao1') selected @endif>天朝一</option>
                                <option value="tianchao3" @if($platform == 'tianchao3') selected @endif>天朝三</option>
                            </select>
                        </div>
                    </div>
                <div class="layui-form-item layui-form-text">
	                <label for="token" class="layui-form-label">
	                    <span class="x-red">*</span>令牌</label>
	                </label>
	                <div class="layui-input-block">
	                    <textarea placeholder="请输入平台管理后台令牌" id="token" name="token" class="layui-textarea">{{$token[0]}}</textarea>
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
            console.log(data.field);
            var id = $('input[name="id"]').val();

            //ajax
            $.ajax({
                url:'/admin/token/'+id,
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
                    if(res.code == '40001'){
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


@extends('admin/common/layout')

@section('content')

<body>
<div class="layui-fluid">
    <div class="layui-row">
        <form action="" method="post" class="layui-form layui-form-pane">
            <input type="hidden" name="handsel_id" value="{{$handsel->handsel_id}}">
           
            <div class="layui-form-item layui-form-text">
                <label for="remark" class="layui-form-label">
                    描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" id="desc" name="desc" class="layui-textarea">{{$handsel->desc}}</textarea>
                </div>
            </div>
            <div class="layui-form-item">
            <button class="layui-btn" lay-submit="" lay-filter="update">更新</button>
            </div>
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
            var handsel_id = $('input[name="handsel_id"]').val();

            //ajax
            $.ajax({
                url:'/admin/handsel/'+handsel_id,
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
                    if(res.code == '30001'){
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


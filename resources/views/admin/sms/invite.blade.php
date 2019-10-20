@extends('admin/common/layout')

@section('content')

<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
                <div class="layui-form-item">
                    <label for="phone" class="layui-form-label">
                        <span class="x-red">*</span>输入手机号码</label>
                    <div class="layui-input-block">
                        <input type="text" id="phone" name="phone"  autocomplete="off" class="layui-input">
                    </div>
                </div>
               
                <div class="layui-form-item">
                    <label for="phone_code" class="layui-form-label">
                        短信验证码</label>
                    <div class="layui-input-block">
                        <input type="text" id="phone_code" name="phone_code" autocomplete="off" class="layui-input" value="" readonly></div>
                </div>
                
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">确认发送</button></div>
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
                url:'/admin/sms/sendSMS',
                data:data.field,
                dataType:'json',
                type:'post',
                headers:{
                    'X-CSRF-TOKEN':"{{csrf_token()}}"
                },
                success:function(res){
                    if(res.code == '1'){
                        $('#phone_code').val(res.data.code);
                        layer.msg(res.data.msg,{icon:6},function(){
                            window.parent.location.reload();
                        })
                    }
                    if(res.code == '0'){
                        
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


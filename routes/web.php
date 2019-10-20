<?php
Route::get('/','Admin\IndexController@jump');                                   // 后台管理--域名直接跳转到登陆页面
Route::get('/admin/login','Admin\AuthController@login')->name('login');         // 后台管理--显示登录
Route::post('/admin/login','Admin\AuthController@DoLogin');                     // 后台管理--登录动作
Route::get('/admin/logout','Admin\AuthController@logout');                      // 后台管理--退出登录

Route::group(['middleware'=>['auth:admin','fangqiang','OSS']],function(){

    Route::get('/admin/welcome','Admin\IndexController@welcome');                   // 后台管理--welcome
    Route::get('/admin/index','Admin\IndexController@index')->name('admin.index');  // 后台管理--后台主页
    
    Route::match(['get','post'],'/admin/manager/unbound','Admin\ManagerController@unbound');                               // 管理员重绑二次验证   
    Route::match(['get','post'],'/admin/manager/reset','Admin\ManagerController@reset');                                   // 管理员密码重置   

    Route::resource('/admin/manager','Admin\ManagerController',['names' => ['show' => 'manager.status']]);              // 管理员资源路由管理  
    Route::match(['get','post'],'/admin/role/{role}/assign','Admin\RoleController@assign')->name('role.assign');        // 给角色分配权限                                                  
    Route::resource('/admin/role','Admin\RoleController',['names' => ['show' => 'role.status']]);                       // 角色资源路由管理
    Route::post('/admin/rule/switch/{param}','Admin\RuleController@switch');                                            // 切换是否显示 是否验证
    Route::resource('/admin/rule','Admin\RuleController');                                                              // 权限资源路由管理
    
    Route::get('/admin/merchant/deploy/{merid}','Admin\MerchantController@deploy');  // 配置公私钥view
    Route::post('/admin/merchant/doDeploy','Admin\MerchantController@doDeploy');     // 配置公私钥
    Route::resource('/admin/merchant','Admin\MerchantController');                   // 后台管理--多商家
    
    Route::get('/admin/order/recheck/{id}','Admin\OrderController@recheck');         // 查看审核订单   
    Route::get('/admin/order/check/{id}','Admin\OrderController@check');             // 查看下发订单
    Route::resource('/admin/order','Admin\OrderController');                         // 订单资源路由管理
    
    Route::post('/admin/recheck/notice','Admin\RecheckController@notice');           // 审核未处理提醒
    Route::resource('/admin/recheck','Admin\RecheckController');                     // 审核下发订单
    
    Route::post('/admin/bank/getOne/{bank}','Admin\BankController@getOne');                         // 获取到指定一条银行信息   
    Route::resource('/admin/bank','Admin\BankController',['names' => ['show' => 'bank.status']]);   // 银行资源路由管理


    Route::resource('/admin/user','Admin\UserController');                           // 后台管理--用户管理
    Route::post('/server/upload/import','Server\UploadController@import');           // 后台管理--导入csv格式

    //Route::resource('/admin/token','Admin\TokenController');                         // 后台管理--令牌管理 (取消)

    Route::resource('/admin/handsel','Admin\HandselController');                     // 后台管理--彩金管理

    Route::resource('/admin/activity','Admin\ActivityController');                   // 后台管理--活动管理

    Route::resource('/admin/platform','Admin\PlatformController');                   // 后台管理--平台管理
    Route::post('/admin/create/relation','Admin\PlatformController@relation');       // 后台管理--手动生成关系表

    
    Route::get('/admin/smslog','Admin\SmsLogController@index');                      // 后台管理--邀请列表
    Route::get('/admin/sms/invite','Server\SMSController@invite');                   // 短信邀请页面
    Route::post('/admin/sms/sendSMS','Server\SMSController@sendSMS');                // 发送短信


});

Route::any('/server/upload/read','Server\UploadController@read');                    // 测试

/**
 * 外人不可获取到这个url地址  
 */
Route::get('/secret/ShowManager','Admin\GoogleTokenController@ShowManager');                           // 后台管理--显示管理员
Route::post('/secret/GoogleToken','Admin\GoogleTokenController@GoogleToken');                          // 后台管理--谷歌验证





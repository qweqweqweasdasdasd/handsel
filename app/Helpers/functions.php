<?php

/**
 * 当前时间
 */

function NowTime()
{
    return date('Y-m-d H:i:s',time());   
}

/**
 * (启用||停用) 状态 
 */
function common_switch_status($code)
{
    switch ($code) {
        case '1':
            return '<button type="button" class="layui-btn layui-btn-danger layui-btn-xs switch-status" data-status="2" >停用</button>';
        case '2':
            return '<button type="button" class="layui-btn layui-btn-normal layui-btn-xs switch-status" data-status="1" >启用</button>';
    }
}

/**
 *  显示状态
 */
function common_status($code)
{
    switch ($code) {
        case '1':
            return '<span class="layui-badge layui-bg-green">成功</span>';
        case '2':
            return '<span class="layui-badge">失败</span>';
    }
}

/**
 *  平台开启关闭显示不同颜色
 */
function platform_status_colour($code,$text)
{
    switch ($code) {
        case '1':
            return '<span class="layui-badge layui-bg-blue">'. $text .'</span>';
        case '2':
            return '<span class="layui-badge">'. $text .'</span>';
    }
}

/**
 * 下发订单状态显示
 * 订单状态 ,1下发提交, 2审核中 3,下发成功 4,下发失败, 5,24小时无处理(失效过期)
 */
function xiafa_order_show_status($code)
{
    switch ($code) {
        case '1':
            return '<span class="layui-badge layui-bg-cyan">'.config('order.status')[1].'</span>';
        case '2':
            return '<span class="layui-badge layui-bg-blue">'.config('order.status')[2].'</span>';
        case '3':
            return '<span class="layui-badge layui-bg-green">'.config('order.status')[3].'</span>';
        case '4':
            return '<span class="layui-badge">'.config('order.status')[4].'</span>';
        case '5':
            return '<span class="layui-badge">'.config('order.status')[5].'</span>';
        case '6':
            return '<span class="layui-badge layui-bg-blue">'.config('order.status')[6].'</span>';
    }
}

/**
 *  彩金类型
 */
function Handsel_type($money)
{
    return '<span class="layui-badge layui-bg-orange">'.$money.'彩金活动</span>';
}

/**
 *  彩金状态
 */
function handsel_show_status($code)
{
    switch ($code) {
        case '1':
            return '<span class="layui-badge layui-bg-blue">申请中</span>';
        case '2':
            return '<span class="layui-badge">账号不符</span>';
        case '3':
            return '<span class="layui-badge layui-bg-gray">其他原因</span>';
        case '4':
            return '<span class="layui-badge layui-bg-green">上分成功</span>';
        case '5':
            return '<span class="layui-badge">手动添加</span>';
        case '6':
            return '<span class="layui-badge"></span>';
    }
    
}


/**
 * 复审状态
 * 复审订单状态 1,已审核 2,未审核
 */
function shenhe_recheck_show_status($code)
{
    switch($code){
        case '1':
            return '<span class="layui-badge layui-bg-green">已审核</span>';
        case '2':
            return '<span class="layui-badge layui-bg-blue">未审核</span>';
    }
}

/**
 * 亨鑫接口返回信息
 */
function interface_return_bank_info($data)
{   
    $is_json = strpos($data,"{");
    if($is_json === false){
        return $data;
    }
    $json =  json_decode($data);
    
    return '实际下发金额:' . $json->amount .'元'. ' 订单号:' . $json->merOrderNo . ' 亨鑫单号:' . $json->orderNo . ' 订单状态:' . status($json->orderState);
}

/**
 * 亨鑫接口返回信息--附加 状态
 */
function status($orderState)
{
    switch ($orderState) {
        case '0':
            return $status = '处理中';
        case '1':
            return $status = '成功';
        case '2':
            return $status = '失败';
    }
}
/**
 * 递归方式获取上下级权限信息
 */
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['rule_id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['pid']])){
            $items[$item['pid']]['son'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return getTreeData($tree);
}
function getTreeData($tree,$level=0){
    static $arr = array();
    foreach($tree as $t){
        $tmp = $t;
        unset($tmp['son']);
        //$tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}

/**
 * PHP 递归无限极分类
 */
function GetTree($array,$pid=0,$level=0)
{
   // 声明静态数组,避免递归多次调用的时候,数据覆盖
   static $list = [];
   foreach ($array as $k => $v) {
      // 第一次遍历,找到pid = 0的所有节点
      if($v['pid'] == $pid){
            // 保存级别
            //$v['lev'] = $level;
            // 把符合条件的数组放到list
            $list[] = $v;
            // 把这个节点删除,减少递归消耗
            unset($array[$k]);
            // 开始递归,查找父id为该节点id的节点,级别设置为1
            GetTree($array,$v['rule_id'],$level+1);
      } 
   }
   return $list;
}

/**
 * 获取当前控制器名
 */
function getCurrentControllerName()
{
    return getCurrentAction()['controller'];
}
/**
 * 获取当前方法名
 */
function getCurrentMethodName()
{
    return getCurrentAction()['method'];
}
/**
 * 获取当前控制器与操作方法的通用函数
 */
function getCurrentAction()
{
    $action = \Route::current()->getActionName();
    //dd($action);exit;
    //dd($action);
    list($class, $method) = explode('@', $action);
    //$classes = explode(DIRECTORY_SEPARATOR,$class);
    $class = str_replace('Controller','',substr(strrchr($class,'\\'),1));
    return ['controller' => $class, 'method' => $method];
}

/**
 * 商户 md5 加密字符串隐藏12位
 */
function str_hide($str,$start,$len)
{
    return substr_replace($str,'*****',$start,$len);
}
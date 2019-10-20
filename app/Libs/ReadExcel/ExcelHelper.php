<?php
namespace App\Libs\ReadExcel;

use DB;
use App\Libs\ToolRedis;
use App\Libs\Table\Apply;
use App\Libs\Table\Handsel;
use App\ErrDesc\ApiErrDesc;
use App\Resphonse\JsonResphonse;
use App\Libs\Table\Submeter;

/**
 * 读取 excel 同步到数据库内或者excel内
 */
class ExcelHelper
{
	/**
	 *	文件路径
	 */
	protected $FilePath;

	/**
	 *	文件路径
	 */
	protected $platform_id = '';

	/**
	 *	文件路径
	 */
	protected $activity_id = '';

	/**
	 *	apply 分表基名
	 */
	protected $applyTableName = 'apply_';

	/**
	 * apply 分表名
	 */
	protected $subtable = '';

	/**
	 *	handsel 分表基名
	 */
	protected $handselTableName = 'handsel_';

	/**
	 * 初始化数据
	 */
	public function __construct($FilePath,$data)
	{
		$this->FilePath = $FilePath;
		$this->platform_id = $data['platform_id'];
		$this->activity_id = $data['activity_id'];
		$this->ApplyTableInit();
		$this->HandselTableInit();
	}

	/**
	 *	彩金列表 初始化
	 */
	public function HandselTableInit()
	{
		$subtable = $this->handselTableName . $this->platform_id;

		// 判断是否表名是否存在,返回数组列表
		$new_arr = (new Submeter())->tableExist();
		
		// 数据库没有表名创建新表
		if(!in_array($subtable, $new_arr)){
			
			// 申请人数据表
			(new Handsel($this->platform_id,$this->activity_id))->createApplyTable();
		}
	}

	/**
	 *	导入 excel 表初始化
	 */
	public function ApplyTableInit()
	{
		$this->subtable = $this->applyTableName . $this->platform_id;

		// 判断是否表名是否存在,返回数组列表
		$new_arr = (new Submeter())->tableExist();
		
		// 数据库没有表名创建新表
		if(!in_array($this->subtable, $new_arr)){
			
			// 申请人数据表
			(new Apply($this->platform_id,$this->activity_id))->createApplyTable();
		}

	}

	/**
	 *	读出放在redis,,同步到mysql,,mysql 分表
	 */ 
	public function Read()
	{
		set_time_limit(0);
		ignore_user_abort(true); //设置客户端断开连接时继续执行脚本
		ini_set('memory_limit','1024M');
		$handle = fopen($this->FilePath, 'rb');
		// 将数据一次性读出来
		$excelData = [];
		while ($row = fgetcsv($handle,1000,',')) {
			$excelData[] = $row;
		}
		
		// 切为
		$chunckData = array_chunk($excelData, 1000);	// 分割为1000小数组
		$count = count($chunckData);
		
		for ($i=0; $i < $count; $i++) { 
			$var = [];
			foreach ($chunckData[$i] as $v) {
				if(is_numeric($v[0])){
					$apply_id = (new ToolRedis())->UniqueId();
 					$phone = mb_convert_encoding($v[0],'UTF-8','GBK');
					$platform_id  = $this->platform_id;					//	平台
					$activity_id  = $this->activity_id;
					$created_at = date('Y-m-d H:i:s',time());
					$str = "('{$apply_id}','{$phone}','{$platform_id}','{$activity_id}','{$created_at}')";
					$var[] = $str;
				}
			}
			$data = implode(',', $var);
			
			// 导入数据库
			$this->WriteMysql($data);
		}
		fclose($handle);
		return true;
	}

	/**
	 *	写入到 redis 
	 */

	public function WriteRedis()
	{
		return 'WriteRead';
	}

	/**
	 *	写入到 mysql
	 */
	public function WriteMysql($data)
	{
		DB::insert(" INSERT INTO {$this->subtable} (`apply_id`,`phone`,`platform_id`,`activity_id`,`created_at`) VALUES {$data}");
	}
}
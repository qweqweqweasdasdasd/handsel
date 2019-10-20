<?php 
namespace App\Libs\Table;


/**
 *  分表处理
 */
class Submeter
{

	/**
	 *	数据库内获取表列表
	 */
	public function tableExist()
	{
		$tableName_arr = \DB::select('show tables');
		
		$new_arr = [];
		foreach ($tableName_arr as $k => $v) {
			$new_arr[] = $v->Tables_in_handsel;
		}

	 	return $new_arr;
	}

	/**
	 *	生成 union 字符串
	 */
	public function createUnion($new_arr,$table)
	{
		$sub_tables = '';
		foreach ($new_arr as $k => $v) {
			if(preg_match("/{$table}\d+/",$v)){
				$sub_tables .= '`'.$v.'`,';
			}
		}
		$sub_tables_str = rtrim($sub_tables,',');

		return $sub_tables_str;
	}

}
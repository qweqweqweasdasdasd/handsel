<?php 
namespace App\Model;

use EasySwoole\Core\Component\Di;

/**
 * 	数据库基类
 */
class Base 
{
	public $db = '';
	
	public function __construct()
	{
		// 检查表名是否为空
		if(empty($this->tableName)){
			throw new \Exception("table is empty");
		}

		// 获取到数据库对象
		$db = Di::getInstance()->get('MYSQL');
		if($db instanceof \MysqliDb){
			$this->db = $db;

		}else{
			throw new \Exception("无 MysqliDb");
		}

	}

	// 新增保存数据库逻辑
	public function create(array $data)
	{
		if(empty($data) || !is_array($data)){
			return false;
		}
		
		return $this->db->insert($this->tableName,$data);
	}

	// 获取到指定的一条数据
	public function getOne($field1,$field2,$value1,$value2)
	{	
		$this->db->where($field1,$value1);
		$this->db->where($field2,$value2);
		$res = $this->db->getOne($this->tableName);

		return !empty($res) ? $res : [];
	}

	// 更新指定的数据
	public function update($f,$v,$data)
	{
		$this->db->where($f,$v);
		return !!($this->db->update($this->tableName,$data));
	}
}
<?php
namespace App\Model;

/**
 *  彩金申请列表
 */
class Apply extends Base
{
	public $tableName = 'apply';

	/**
	 *	构造函数
	 */
	public function __construct($platform_id)
	{
		$this->tableName = 'apply_'.$platform_id;
		
		parent::__construct();	//	父类构造函数
	}
}
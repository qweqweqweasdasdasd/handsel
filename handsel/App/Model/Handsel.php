<?php
namespace App\Model;

/**
 *  彩金申请列表
 */
class Handsel extends Base
{
	public $tableName = 'handsel';

	/**
	 *	构造函数
	 */
	public function __construct($platform_id)
	{
		$this->tableName = 'handsel_'.$platform_id;

		parent::__construct();	//	父类构造函数
	}
	
}
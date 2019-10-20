<?php 
namespace App\Libs\Table;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 *  用户表
 */
class Apply
{
	/**
	 *	平台id
	 */
	protected $platform_id = '';

	/**
	 *	活动id
	 */
	protected $activity_id = '';


	/**
	 *	初始化
	 */
	public function __construct($platform_id,$activity_id)
	{
		$this->activity_id = $activity_id;
		$this->platform_id = $platform_id;
	}

	/**
	 *	创建子表
	 */
	public function createApplyTable()
	{
		Schema::create('apply_'.$this->platform_id, function (Blueprint $table) {
            $table->bigInteger('apply_id');
            $table->string('phone',15)->default('');
            $table->string('username',30)->default('');
            $table->integer('platform_id')->default(0);
            $table->integer('activity_id')->default(0);
            $table->tinyInteger('is_success')->default(0);
            $table->index(['phone', 'platform_id']);
            $table->engine = 'MyISAM';
            $table->timestamps();
        });

        // 更新主表
        $this->ApplyTable();
	}

	/**
	 *	创建主表
	 */
	public function ApplyTable()
	{
		// 判断是否表名是否存在,返回数组列表
		$new_arr = (new Submeter())->tableExist();

		// 生成 union 字符串
		$sub_tables_str = (new Submeter())->createUnion($new_arr,'apply_');

		\DB::select("DROP TABLE IF EXISTS `apply`;");

		$sql = "CREATE TABLE `apply` (
				  `apply_id` bigint(20) NOT NULL,
				  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				  `platform_id` int(11) NOT NULL DEFAULT '0',
				  `activity_id` int(11) NOT NULL DEFAULT '0',
				  `is_success` tinyint(4) NOT NULL DEFAULT '0',
				  `created_at` timestamp NULL DEFAULT NULL,
				  `updated_at` timestamp NULL DEFAULT NULL, 
				  KEY `apply_3_phone_platform_id_index` (`phone`,`platform_id`)
				) ENGINE=MRG_MyISAM  DEFAULT CHARSET=utf8mb4 INSERT_METHOD=No union =(".$sub_tables_str.");";

		\DB::select($sql);
	}

}
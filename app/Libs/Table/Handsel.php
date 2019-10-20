<?php 
namespace App\Libs\Table;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 *  用户表
 */
class Handsel
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
		Schema::create('handsel_'.$this->platform_id, function (Blueprint $table) {
            $table->bigInteger('handsel_id');
            $table->string('order_no',150)->default('')->index();
            $table->string('username',30)->default('')->index();
            $table->string('phone',15)->default('');
            $table->integer('type')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->integer('platform_id')->default(0);
            $table->string('desc',255)->default('');

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
		$sub_tables_str = (new Submeter())->createUnion($new_arr,'handsel_');

		\DB::select("DROP TABLE IF EXISTS `handsel_`;");

		$sql = "CREATE TABLE `handsel_` (
				  `handsel_id` bigint(20) NOT NULL,
				  `order_no` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				  `type` int(11) NOT NULL DEFAULT '0',
				  `status` tinyint(4) NOT NULL DEFAULT '0',
				  `platform_id` int(11) NOT NULL DEFAULT '0',
				  `desc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
				  `created_at` timestamp NULL DEFAULT NULL,
				  `updated_at` timestamp NULL DEFAULT NULL,
				  KEY `handsel_1_phone_platform_id_index` (`phone`,`platform_id`),
				  KEY `handsel_1_order_no_index` (`order_no`),
				  KEY `handsel_1_username_index` (`username`)
				) ENGINE=MRG_MyISAM  DEFAULT CHARSET=utf8mb4 INSERT_METHOD=No union =(".$sub_tables_str.");";

		\DB::select($sql);
	}

}
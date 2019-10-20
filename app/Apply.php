<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Admin\AdminData;

class Apply extends Model
{
    protected $primaryKey = 'apply_id';
	public $table = 'apply';
    protected $fillable = [
    	'phone','username','platform_id'
    ];

    
    /**
     *	设置表名
     */
    public function setTable($table)
    {
    	$GetPfId = (new AdminData())->GetPfId();
    	$this->table = $GetPfId ? $table.'_'.$GetPfId :'apply';
    	
    	return $this;
    }
}

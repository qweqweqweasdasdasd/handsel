<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Admin\AdminData;

class Handsel extends Model
{
    protected $primaryKey = 'handsel_id';
	public $table = 'handsel';
    protected $fillable = [
    	'username','phone','type','status','platform_id','desc'
    ];

    /**
     *	设置表名
     */
    public function setTable($table)
    {
    	$GetPfId = (new AdminData())->GetPfId();
    	$this->table = $GetPfId ? $table.'_'.$GetPfId :'handsel_';
    	
    	return $this;
    }
}

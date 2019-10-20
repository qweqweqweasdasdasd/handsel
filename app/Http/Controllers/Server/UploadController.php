<?php

namespace App\Http\Controllers\Server;

use App\Libs\ReadExcel;
use App\Libs\Table\Apply;
use App\ErrDesc\ApiErrDesc;
use Illuminate\Http\Request;
use App\Resphonse\JsonResphonse;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
  	/**
  	 *	设置文件后缀白名单
  	 */
  	protected $allowExt = ['csv'];

  	/**
  	 *	设置存储目录
  	 */
  	protected $path = '/storage/upload/';

  	/**
  	 *	文件对象
  	 */
  	protected $file = '';

  	/**
  	 *	文件后缀
  	 */
  	protected $ext = '';

  	/**
  	 *	文件大小
  	 */
  	protected $maxSize = 83886080;	        // 80M

  	/**
  	 *	文件名称
  	 */
  	protected $fileName = 'excel.';

    /**
     *	excel 导入
     */
    public function import(Request $request)
    {
      $data = [
        'platform_id' => $request->get('platform_id'),
        'activity_id' => $request->get('activity_id')
      ];

    	$subPath = 'DB/';
    	$basePath = public_path() . $this->path . $subPath;
    	if(!is_dir($basePath)){
    		mkdir($basePath,0777,true);
    	}

    	// 获取到文件对象
    	$this->file = $request->file('file');
    	
    	try {
    		// 检验上传文件后缀
    		$this->VerifyFileExt();
    		// 检验上传文件的大小
    		$this->VerifyFileSize();
    		// 移动文件到服务器
    		$fileObj = $this->file->move($basePath,$this->fileName.$this->ext);
    		//$path = public_path() .'/storage/upload/DB/excel.xls';
    		$path = public_path() .'/storage/upload/DB/excel.csv';
        
   			$eh = new \App\Libs\ReadExcel\ExcelHelper($path,$data);
   			$res = $eh->Read();
    	} catch (\Exception $e) {
    		return JsonResphonse::JsonData('422',$e->getMessage());
    	}
    	if($res){
    		return JsonResphonse::ResphonseSuccess();
    	}
    	return false;
    }

    /**
     *	检验上传文件的大小
     */ 
    public function VerifyFileSize()
    {
    	$size = $this->file->getClientSize();
    	
    	if($size > $this->maxSize){
    		$textSize = floor($this->maxSize/1024/1024);
    		throw new \Exception("上传文件最大为: {$textSize}M!");
    	}
    }

   	/**
   	 *	检验上传文件后缀
   	 */
   	public function VerifyFileExt()
   	{
   		$this->ext = $this->file->getClientOriginalExtension();	// 上传文件的后缀

   		if(!in_array($this->ext, $this->allowExt)){
   			throw new \Exception("{$this->ext}: 上传文件的后缀不在白名单内!");
   		}
   	}

   	/**
   	 *	读excel数据
   	 */
   	public function read()
   	{
   		$path = public_path() .'/storage/upload/DB/excel.csv';
   		$eh = new \App\Libs\ReadExcel\ExcelHelper($path);

   		dd($eh->Read());
   	}
   	
}

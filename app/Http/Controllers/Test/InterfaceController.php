<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Libs\Platform\EznPoint;
use App\Http\Controllers\Controller;

class InterfaceController extends Controller
{
    /**
     *	查询平台会员是否存在
     */
    public function VerifyPlatformUser()
    {
    	$ezn = new EznPoint();

    	$res = $ezn->VerifyPlatformUser('allen');

    	dd($res);
    }

    /**
     *	平台会员存款
     */
    public function DoPlatformPoint()
    {
    	$ezn = new EznPoint();

    	$data = [
    		'platform'=> 'ezn',
            'balance'=> '2.5',
            'note'=> '123123',
            'username'=> 'allen',
            'user_id'=> '2732588'
    	];

    	$res = $ezn->DoPlatformPoint($data);

    	dd($res);
    }
}

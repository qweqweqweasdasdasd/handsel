<?php
namespace App\HttpController\Api;

use App\HttpController\Api\Base;

class Index extends Base
{
    function index()
    {
        // TODO: Implement index() method.
        $this->response()->write('hello api');
    }
}
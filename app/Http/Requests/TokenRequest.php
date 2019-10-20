<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TokenRequest extends FormRequest
{
    /**
     * 定义验证规则
     */
    protected $rules = [
        'platform' => 'required|max:16|min:2',
        'token' => 'required'
    ];
    /**
     * 定义错误信息
     */
    protected $messages = [
        'platform.required' => '平台名称必须填写',
        'platform.max' => '平台不得超出16个字符',
        'platform.min' => '平台不得小于2个字符',
        'token.required' => 'Token必须填写'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        if(Request::isMethod('PATCH')){
            $rules['mg_name'] = 'required|max:16|min:2';
            $rules['password'] = '';
        }
        return $rules;
    }

    /**
     * 自定义错误
     */
    public function messages()
    {
        $messages = $this->messages;

        return $messages;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMSRequest extends FormRequest
{
    /**
     * 定义验证规则
     */
    protected $rules = [
        'phone' => 'required|regex:/^1[3456789]\d{9}$/'
    ];
    /**
     * 定义错误信息
     */
    protected $messages = [
        'phone.required' => '手机号码必须存在!',
        'phone.regex' => '手机号码格式不符合!'
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = $this->rules;
        
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlatformRequest extends FormRequest
{
    /**
     * 定义验证规则
     */
    protected $rules = [
        'pf_name' => 'required|max:12,min:2',
        'mark' => 'required|alpha_num',
        'platform_status' => 'required|in:1,2',
        'token' => 'required|alpha_num',
    ];
    /**
     * 定义错误信息
     */
    protected $messages = [
        'pf_name.required' => '平台名称必须存在!',
        'pf_name.max' => '平台名称不得超出12个字符!',
        'pf_name.min' => '平台名称不得小于2个字符!',

        'mark.required' => '',
        'mark.alpha_num' => '',

        'platform_status.required' => '',
        'platform_status.in' => '',

        'token.required' => '',
        'token.alpha_num' => '',
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
        if(Request::isMethod('PATCH')){
            
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

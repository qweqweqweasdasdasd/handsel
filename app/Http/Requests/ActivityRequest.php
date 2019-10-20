<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ActivityRequest extends FormRequest
{
    /**
     * 定义验证规则
     */
    protected $rules = [
        'activity_name' => 'required|unique:activity|max:16|min:2',
        'activity_money' => 'required|integer',
        'platform_ids' => 'required|array',
        'activity_status' => 'required|in:1,2',
        'desc' => 'max:255'
    ];
    /**
     * 定义错误信息
     */
    protected $messages = [
        'activity_name.required' => '活动名必须存在',
        'activity_name.unique' => '活动名重复',
        'activity_name.max' => '活动名不得超出16个字符',
        'activity_name.min' => '活动名不得小于2个字符',

        'activity_money.required' => '活动金额必须存在',
        'activity_money.integer' => '活动金额不符合格式',
        
        'platform_ids.required' => '平台id必须存在',
        'platform_ids.array' => '平台id格式不对',
        
        'activity_status.required' => '活动状态必须存在',
        'activity_status.in' => '活动状态格式不对',
        
        'desc.max' => '备注不得超出255个字符'
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
            $rules['activity_name'] = 'required|max:16|min:2';
    
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

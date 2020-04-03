<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlackRequest extends FormRequest
{
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
        return [
            'channel_name' => 'bail|required|max:255',
            'remind_content' => 'required|max:255',
            'webhook_address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'channel_name' => 'チャンネル名が不足してます。',
            'remind_content' => '通知する内容が不足してます。',
            'webhook_address' => 'WebHookアドレスは必須です。',
            'deadline' => '締切日は必須です。'
        ];
    }
}

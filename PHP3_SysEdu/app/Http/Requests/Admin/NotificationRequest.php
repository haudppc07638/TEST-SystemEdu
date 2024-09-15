<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date_sent' => 'required|date|after:now',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là 1 chuỗi ký tự',
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'content.required' => 'Vui lòng nhập nội dung.',
            'content.string' => 'Nội dung phải là 1 chuỗi ký tự.',
            'date_sent.required' =>'Vui lòng chọn thời gian gửi',
            'date_sent.after' => 'Thời gian gửi phải lớn hơn thời gian hiện tại.',
        ];
    }
}

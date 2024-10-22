<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ScoreTypeRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên loại điểm là bắt buộc.',
            'name.string' => 'Tên loại điểm phải là một chuỗi.',
            'name.max' => 'Tên loại điểm không được quá 100 ký tự.',
        ];
    }
}

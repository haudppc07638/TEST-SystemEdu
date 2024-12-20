<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'image' => $this->isMethod('put') ? 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048' : 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'content' => 'required|string|min:20',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề không được để trống',
            'image.required' => 'Ảnh không được để trống',

            'image.image' => 'Ảnh không đúng định dạng',
            'image.mimes' => 'Ảnh không đúng định dạng',
            'image.max' => 'Ảnh không được lớn hơn 2MB',
            
            'content.required' => 'Nội dung không được để trống',
            'content.min' => 'Nội dung quá ngắn, phải có ít nhất 20 ký tự',
        ];
    }
}

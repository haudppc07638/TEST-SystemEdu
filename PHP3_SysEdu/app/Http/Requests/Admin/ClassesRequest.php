<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClassesRequest extends FormRequest
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
        return[
            'name' => 'required|string|max:10|',
            'trainingsystem' => 'required|string|max:100|',
            'employee_id' => $this->isMethod('put') ? [
                'nullable', // Không bắt buộc khi cập nhật
            ] : [
                'required',
            ],
        ];

    }

    public function messages(){
        return [
        'name.required' => 'Tên lớp không được để trống',
        'name.string' => 'Tên lớp phải là 1 chuỗi ký tự',
        'name.max' => 'Tên lớp không được nhập quá 10 ký tự',

        'trainingsystem.required' => 'Hệ đào tạo không được để trống',
        'trainingsystem.string' => 'Hệ đào tạo là 1 chuỗi ký tự',
        'trainingsystem.max' => 'Hệ đào tạo không được nhập quá 100 ký tự',

        'employee_id.required' => 'Nhân viên không được để trống'
        ];
    }
}

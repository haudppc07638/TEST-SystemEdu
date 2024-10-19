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
        return [
            'name' => 'required|string|max:10',
            'training_system' => 'required|string|max:100',
            'employee_id' => $this->isMethod('put') ? ['nullable'] : ['required'],
            'start_date' => [
                'required',
                'date',
                'after:today',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:60'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên lớp không được để trống',
            'name.string' => 'Tên lớp phải là 1 chuỗi ký tự',
            'name.max' => 'Tên lớp không được nhập quá 10 ký tự',

            'training_system.required' => 'Hệ đào tạo không được để trống',
            'training_system.string' => 'Hệ đào tạo là 1 chuỗi ký tự',
            'training_system.max' => 'Hệ đào tạo không được nhập quá 100 ký tự',

            'employee_id.required' => 'Nhân viên không được để trống',

            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ',
            'start_date.after' => 'Ngày bắt đầu phải lớn hơn ngày hiện tại',

            'quantity.required' => 'Số lượng không được để trống',
            'quantity.integer' => 'Số lượng phải là một số nguyên',
            'quantity.min' => 'Số lượng phải ít nhất là 1',
            'quantity.max' => 'Số lượng không được vượt quá 60',
        ];
    }
}

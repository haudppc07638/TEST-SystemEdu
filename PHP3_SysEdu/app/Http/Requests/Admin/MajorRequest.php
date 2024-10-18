<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MajorRequest extends FormRequest
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
        $majorId = $this->route('id');

        return [
            'name' => 'required|string|max:100',
            'faculty_id' => 'required|exists:faculties,id',
            'code' => ['required', 'string', 'max:15', Rule::unique('majors')->ignore($majorId)],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *dd
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên chuyên ngành không được để trống',
            'name.string' => 'Tên chuyên ngành phải là 1 chuỗi ký tự',
            'name.max' => 'Tên chuyên ngành không được nhập quá 100 ký tự',

            'faculty_id.required' => 'Khoa không được để trống',
            'faculty_id.exists' => 'Khoa không hợp lệ',

            'code.required' => 'Mã chuyên ngành không được để trống',
            'code.string' => 'Mã chuyên ngành phải là 1 chuỗi ký tự',
            'code.unique' => 'Mã chuyên ngành đã tồn tại',
            'code.max' => 'Mã chuyên ngành không được quá 15 ký tự',
        ];
    }
}

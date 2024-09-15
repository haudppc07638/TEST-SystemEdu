<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FacultyRequest extends FormRequest
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
        $facultyId = $this->route('id');
        return[
            'name' => 'required|string|max:50|',Rule::unique('faculty')->ignore($facultyId),
            'code' => 'required|string|max:10|',Rule::unique('faculty')->ignore($facultyId),
            'dean' => 'nullable',
            'assistant_dean' => 'nullable',
            'description' => 'required|string|max:255|'
        ];
    }
    public function messages(){
        return [
        'name.required' => 'Tên khoa không được để trống',
        'name.string' => 'Tên khoa phải là 1 chuỗi ký tự',
        'name.unique' => 'Tên khoa đã tồn tại!',
        'name.max' => 'Tên khoa không được nhập quá 50 ký tự',
        'code.required' => 'Mã khoa không được để trống',
        'code.string' => 'Mã khoa phải là 1 chuỗi ký tự',
        'code.unique' => 'Mã khoa đã tồn tại!',
        'code.max' => 'Mã khoa không được nhập quá 10 ký tự',
        'description.required' => 'Mô tả không được để trống',
        'description.string' => 'Mô tả phải là 1 chuỗi ký tự',
        'description.max' => 'Không được nhập quá 255 ký tự'
        ];
    }
    
    
}

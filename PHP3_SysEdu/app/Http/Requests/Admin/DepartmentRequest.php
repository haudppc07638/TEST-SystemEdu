<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
        $departmentId = $this->route('id');

        return[
            'name' => ['required', 'string', 'max:100', Rule::unique('departments')->ignore($departmentId)],
            'location' => 'required|string|max:100',
        ];
    }

    public function messages(){
        return [
        'name.required' => 'Tên phòng ban không được để trống',
        'name.string' => 'Tên phòng ban phải là 1 chuỗi ký tự',
        'name.unique' => 'Tên phòng ban đã tồn tại!',
        'name.max' => 'Tên phòng ban không được nhập quá 100 ký tự',
        'location.required' => 'Vị trí không được để trống',
        'location.string' => 'Vị trí phải là 1 chuỗi ký tự',
        'location.max' => 'Vị trí không được nhập quá 100 ký tự',
        ];
    }
}

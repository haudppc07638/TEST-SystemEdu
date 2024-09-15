<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        $employeeID = $this->route('id');

        return [
            'fullname' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:60',
                Rule::unique('employees')->ignore($employeeID)
            ],
            'password' => $this->isMethod('post') ? [ // If the request method is POST (creation), make password required
                'required',
                'string',
                'min:8',
                'max:60',
                'regex:/^[A-Za-z0-9@]+$/'
            ] : '',
            'phone' => [
                'required',
                'max:15',
                'regex:/^0\d{9}$/',
                Rule::unique('employees')->ignore($employeeID)
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => [
                'required',
                'string',
                'in:Giáo viên,Cán bộ đào tạo',
                'max:50'
            ],
            'faculty_id' => 'required',
            'department_id' => 'required',
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'fullname.required' => 'Họ và tên không được để trống',
            'fullname.string' => 'Họ và tên phải là một chuỗi ký tự',
            'fullname.max' => 'Họ và tên không được vượt quá 100 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ',
            'email.max' => 'Email không được vượt quá 60 ký tự',
            'email.unique' => 'Email đã tồn tại trong hệ thống',

            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.max' => 'Mật khẩu không được vượt quá 60 ký tự',
            'password.regex' => 'Mật khẩu chỉ được chứa các ký tự từ A-Z, a-z, 0-9, và @',

            'phone.required' => 'Số điện thoại không được để trống',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
            'phone.regex' => 'Số điện thoại không đúng định dạng',

            'image.image' => 'Hình ảnh không hợp lệ',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, hoặc gif',
            'image.max' => 'Hình ảnh không được vượt quá 2MB',

            'position.required' => 'Chức vụ không được để trống',
            'position.string' => 'Chức vụ phải là một chuỗi ký tự',
            'position.in' => 'Chức vụ không hợp lệ',
            'position.max' => 'Chức vụ không được vượt quá 50 ký tự',

            'faculty_id.required' => 'Khoa không được để trống',

            'department_id.required' => 'Phòng ban không được để trống',
        ];
    }
}

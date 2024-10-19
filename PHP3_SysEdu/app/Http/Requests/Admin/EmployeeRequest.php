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
            'full_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:60',
                Rule::unique('employees')->ignore($employeeID)
            ],
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
                'in:admin,teacher',
                'max:50'
            ],
            'code' => 'required|string|max:15|unique:employees,code,' . $employeeID,
            'gender' => 'required|in:0,1',
            'major_id' => 'required',
            'department_id' => 'required',
            'nation' => 'nullable|string|max:100',
            'educational_level' => 'nullable|string|max:100',
            'identity_card' => 'nullable|string|max:20|unique:employees,identity_card,' . $employeeID,
            'card_issuance_date' => 'nullable|date',
            'card_location' => 'nullable|string|max:100',
            'house_number' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'year_graduation' => 'nullable|integer|min:1900|max:' . date('Y'),
            'graduate' => 'nullable|string|max:100',
            'provice_city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'commune_level' => 'nullable|string|max:255',
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
            'full_name.required' => 'Họ và tên không được để trống',
            'full_name.string' => 'Họ và tên phải là một chuỗi ký tự',
            'full_name.max' => 'Họ và tên không được vượt quá 100 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ',
            'email.max' => 'Email không được vượt quá 60 ký tự',
            'email.unique' => 'Email đã tồn tại trong hệ thống',

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

            'gender.required' => 'Giới tính không được để trống',
            'gender.in' => 'Giới tính không hợp lệ',
            'department_id.required' => 'Phòng ban không được để trống',
            'department_id.exists' => 'Phòng ban không tồn tại.',
            'major_id.required' => 'Trường chuyên nghành là bắt buộc.',
            'major_id.exists' => 'Chuyên ngành không tồn tại.',
            'nation.max' => 'Trường quốc tịch không được vượt quá 100 ký tự.',
            'educational_level.max' => 'Trường trình độ học vấn không được vượt quá 100 ký tự.',
            'identity_card.max' => 'Số CMND không được vượt quá 20 ký tự.',
            'identity_card.unique' => 'Số CMND đã tồn tại.',
            'card_location.max' => 'Nơi cấp không được vượt quá 100 ký tự.',
            'house_number.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'year_graduation.integer' => 'Năm tốt nghiệp phải là số nguyên.',
            'year_graduation.min' => 'Năm tốt nghiệp không được nhỏ hơn 1900.',
            'year_graduation.max' => 'Năm tốt nghiệp không được lớn hơn năm hiện tại.',
            'graduate.max' => 'Trường tốt nghiệp không được vượt quá 100 ký tự.',
        ];
    }
}

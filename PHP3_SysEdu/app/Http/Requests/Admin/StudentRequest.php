<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $studentID = $this->route('id');

        return [
            'full_name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('students')->ignore($studentID)
            ],
            'phone' => [
                'required',
                'min:10',
                'max:15',
                'regex:/^0\d{9}$/',
                Rule::unique('students')->ignore($studentID)
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'identity_card' => [
                'required',
                'string',
                'max:15',
                Rule::unique('students')->ignore($studentID)
            ],

            'card_issuance_date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
            'card_location' => 'required|string|max:150',
            'provice_city' => 'required|string|max:150',
            'district' => 'required|string|max:150',
            'commune_level' => 'required|string|max:150',
            'house_number' => 'required|string|max:10',
            'sponsor_name' => 'required|string|max:150',
            'sponsor_phone' => [
                'required',
                'max:15',
                'min:10',
                'regex:/^0\d{9}$/'
            ],
            'major_id' => 'required|exists:majors,id',
            'major_class_id' => 'required|exists:major_classes,id',

            'gender' => 'required|in:0,1',
            'date_of_birth' => 'required|date|before:today|date_format:Y-m-d',
            'nation' => 'required|string|max:100',
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
        'email.max' => 'Email không được vượt quá 100 ký tự',
        'email.unique' => 'Email đã tồn tại trong hệ thống',

        'phone.required' => 'Số điện thoại không được để trống',
        'phone.min' => 'Số điện thoại không được dưới 10 ký tự',
        'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
        'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
        'phone.regex' => 'Vui lòng nhập số điện thoại theo định dạng sau: 0xxxxxxxxx',

        'image.image' => 'Hình ảnh không hợp lệ',
        'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, hoặc gif',
        'image.max' => 'Hình ảnh không được vượt quá 2MB',

        'identity_card.required' => 'Số chứng minh nhân dân không được để trống',
        'identity_card.string' => 'Số chứng minh nhân dân phải là một chuỗi ký tự',
        'identity_card.max' => 'Số chứng minh nhân dân không được vượt quá 15 ký tự',
        'identity_card.unique' => 'Số chứng minh nhân dân đã tồn tại trong hệ thống',

        'card_issuance_date.required' => 'Ngày cấp CMND/CCCD không được để trống',
        'card_issuance_date.date' => 'Ngày cấp CMND/CCCD phải là một ngày hợp lệ',
        'card_issuance_date.date_format' => 'Ngày cấp CMND/CCCD phải theo định dạng Y-m-d',
        'card_issuance_date.before_or_equal' => 'Ngày cấp CMND/CCCD không được lớn hơn ngày hôm nay',

        'card_location.required' => 'Nơi cấp CMND/CCCD không được để trống',
        'card_location.string' => 'Nơi cấp CMND/CCCD phải là một chuỗi ký tự',
        'card_location.max' => 'Nơi cấp CMND/CCCD không được vượt quá 150 ký tự',

        'provice_city.required' => 'Tỉnh/Thành phố không được để trống',
        'provice_city.string' => 'Tỉnh/Thành phố phải là một chuỗi ký tự',
        'provice_city.max' => 'Tỉnh/Thành phố không được vượt quá 150 ký tự',

        'district.required' => 'Quận/Huyện không được để trống',
        'district.string' => 'Quận/Huyện phải là một chuỗi ký tự',
        'district.max' => 'Quận/Huyện không được vượt quá 150 ký tự',

        'commune_level.required' => 'Xã/Phường không được để trống',
        'commune_level.string' => 'Xã/Phường phải là một chuỗi ký tự',
        'commune_level.max' => 'Xã/Phường không được vượt quá 150 ký tự',

        'house_number.required' => 'Số nhà không được để trống',
        'house_number.string' => 'Số nhà phải là một chuỗi ký tự',
        'house_number.max' => 'Số nhà không được vượt quá 10 ký tự',

        'sponsor_name.required' => 'Tên người bảo trợ không được để trống',
        'sponsor_name.string' => 'Tên người bảo trợ phải là một chuỗi ký tự',
        'sponsor_name.max' => 'Tên người bảo trợ không được vượt quá 150 ký tự',

        'sponsor_phone.required' => 'Số điện thoại người bảo trợ không được để trống',
        'sponsor_phone.min' => 'Số điện thoại người bảo trợ không được dưới 10 ký tự',
        'sponsor_phone.max' => 'Số điện thoại người bảo trợ không được vượt quá 15 ký tự',
        'sponsor_phone.regex' => 'Vui lòng nhập số điện thoại theo định dạng sau: 0xxxxxxxxx',

        'major_id.required' => 'Ngành học không được để trống',
        'major_id.exists' => 'Ngành học không tồn tại',

        'major_class_id.required' => 'Lớp học không được để trống',
        'major_class_id.exists' => 'Lớp học không tồn tại',

        'gender.required' => 'Giới tính không được để trống',
        'gender.in' => 'Giới tính phải là (nữ) hoặc (nam)',

        'date_of_birth.required' => 'Ngày sinh không được để trống',
        'date_of_birth.date' => 'Ngày sinh phải là một ngày hợp lệ',
        'date_of_birth.before' => 'Ngày sinh không được lớn hơn hôm nay',
        'date_of_birth.date_format' => 'Ngày sinh phải theo định dạng Y-m-d',

        'nation.required' => 'Quốc tịch không được để trống',
        'nation.string' => 'Quốc tịch phải là một chuỗi ký tự',
        'nation.max' => 'Quốc tịch không được vượt quá 100 ký tự',
    ];
}

}

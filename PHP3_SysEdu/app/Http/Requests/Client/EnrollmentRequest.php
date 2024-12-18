<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|integer',
            'nation' => 'required|string|max:100',
            'identity_card' => 'required|string|max:15',
            'card_issuance_date' => 'required|date',
            'card_location' => 'required|string|max:255',
            'province_city' => 'required|string|max:150',
            'district' => 'required|string|max:150',
            'commune_level' => 'required|string|max:150',
            'house_number' => 'required|string|max:10',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:150|unique:enrollments,email',
            'sponsor_name' => 'required|string|max:150',
            'sponsor_phone' => 'required|string|max:15',
            'first_major_id' => 'required|exists:majors,id',
            'application_method_1' => 'required|in:grade_score,exam_score',
            'year_graduation' => 'required|digits:4',
            'province_city_graduate' => 'required|string|max:150',
            'district_graduate' => 'required|string|max:150',
            'commune_level_graduate' => 'required|string|max:150',
            'recipient' => 'required|in:student,parents',
            'address' => 'required|in:residence_address,at_school',
            'front_id_card' => 'required|string|max:255',
            'back_id_card' => 'required|string|max:255',
            'graduation_certificate' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ tên đầy đủ.',
            'full_name.string' => 'Họ tên phải là một chuỗi ký tự.',
            'full_name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'date_of_birth.required' => 'Vui lòng nhập ngày sinh.',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.integer' => 'Giới tính phải là một số nguyên.',
            'nation.required' => 'Vui lòng nhập quốc tịch.',
            'nation.string' => 'Quốc tịch phải là một chuỗi ký tự.',
            'nation.max' => 'Quốc tịch không được vượt quá 100 ký tự.',
            'identity_card.required' => 'Vui lòng nhập số căn cước.',
            'identity_card.string' => 'Số căn cước phải là một chuỗi ký tự.',
            'identity_card.max' => 'Số căn cước không được vượt quá 15 ký tự.',
            'card_issuance_date.required' => 'Vui lòng nhập ngày cấp căn cước.',
            'card_issuance_date.date' => 'Ngày cấp căn cước không hợp lệ.',
            'card_location.required' => 'Vui lòng nhập nơi cấp căn cước.',
            'card_location.string' => 'Nơi cấp căn cước phải là một chuỗi ký tự.',
            'province_city.required' => 'Vui lòng nhập tỉnh/thành phố.',
            'district.required' => 'Vui lòng nhập quận/huyện.',
            'commune_level.required' => 'Vui lòng nhập xã/phường.',
            'house_number.required' => 'Vui lòng nhập số nhà.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 150 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',
            'sponsor_name.required' => 'Vui lòng nhập tên người bảo trợ.',
            'sponsor_name.string' => 'Tên người bảo trợ phải là một chuỗi ký tự.',
            'sponsor_name.max' => 'Tên người bảo trợ không được vượt quá 150 ký tự.',
            'sponsor_phone.required' => 'Vui lòng nhập số điện thoại người bảo trợ.',
            'first_major_id.required' => 'Vui lòng chọn ngành học đầu tiên.',
            'first_major_id.exists' => 'Ngành học đầu tiên không hợp lệ.',
            'application_method_1.required' => 'Vui lòng chọn phương thức đăng ký nguyện vọng 1.',
            'application_method_1.in' => 'Phương thức đăng ký nguyện vọng 1 không hợp lệ.',
            'year_graduation.required' => 'Vui lòng nhập năm tốt nghiệp.',
            'year_graduation.digits' => 'Năm tốt nghiệp phải có 4 chữ số.',
            'province_city_graduate.required' => 'Vui lòng nhập tỉnh/thành phố tốt nghiệp.',
            'district_graduate.required' => 'Vui lòng nhập quận/huyện tốt nghiệp.',
            'commune_level_graduate.required' => 'Vui lòng nhập xã/phường tốt nghiệp.',
            'recipient.required' => 'Vui lòng chọn đối tượng nhận.',
            'recipient.in' => 'Đối tượng nhận không hợp lệ.',
            'address.required' => 'Vui lòng chọn địa chỉ.',
            'address.in' => 'Địa chỉ không hợp lệ.',
            'front_id_card.required' => 'Vui lòng nhập ảnh mặt trước căn cước.',
            'back_id_card.required' => 'Vui lòng nhập ảnh mặt sau căn cước.',
            'graduation_certificate.required' => 'Vui lòng nhập chứng chỉ tốt nghiệp.',
        ];
    }
}

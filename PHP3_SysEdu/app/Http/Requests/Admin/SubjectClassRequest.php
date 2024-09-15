<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectClassRequest extends FormRequest
{
    
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
        $subjectclassId=$this->route('id');
        return [
            'quantity' => 'required|integer|min:1',
            'name'=>['required',Rule::unique('subject_classes')->ignore($subjectclassId)],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before:start_date|before:end_date',
            'employee_id' => 'required',
            'subject_id' => 'required',
            'semester_id' => 'required',
            
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'=>'Tên là bắt buộc',
            'name.unique'=>'Tên không được để giống nhau',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'registration_deadline.required' => 'Hạn đăng ký là bắt buộc.',
            'registration_deadline.date' => 'Hạn đăng ký phải là ngày hợp lệ.',
            'registration_deadline.before' => 'Hạn đăng ký phải trước ngày bắt đầu và ngày kết thúc.',
            'employee_id.required' => 'Giảng viên là bắt buộc.',
            'subject_id.required' => 'Môn học là bắt buộc.',
            'semester_id.required' => 'Học kỳ là bắt buộc.',

        ];
    }
}

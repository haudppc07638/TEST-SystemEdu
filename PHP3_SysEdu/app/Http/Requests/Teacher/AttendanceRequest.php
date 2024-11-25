<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:0,on'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'Ngày điểm danh là bắt buộc.',
            'date.date' => 'Ngày điểm danh không hợp lệ.',
            'attendance.required' => 'Dữ liệu điểm danh là bắt buộc.',
        ];
    }
}
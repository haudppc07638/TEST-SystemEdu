<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $currentYear = Carbon::now()->year;

        return [
            'block' => 'required|string|max:50',
            'year' => [
                'required',
                'integer',
                'min:' . $currentYear,
            ],
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $year = $this->input('year');
                    if (Carbon::parse($value)->year < $year) {
                        $fail("Phải thuộc năm học $year hoặc muộn hơn.");
                    }
                },
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            "block.required" => "Kỳ học không được để trống.",
            "block.string" => "Kỳ học phải là một chuỗi ký tự.",
            "block.max" => "Kỳ học không được vượt quá 50 ký tự.",

            "year.required" => "Vui lòng chọn năm.",
            "year.integer" => "Năm phải là một số nguyên.",
            "year.min" => "Năm không được nhỏ hơn năm hiện tại.",

            "start_date.required" => "Ngày bắt đầu không được để trống.",
            "start_date.date" => "Ngày bắt đầu phải là một ngày hợp lệ.",
            "start_date.after_or_equal" => "Ngày bắt đầu phải từ hôm nay trở đi.",

            "end_date.required" => "Ngày kết thúc không được để trống.",
            "end_date.date" => "Ngày kết thúc phải là một ngày hợp lệ.",
            "end_date.after" => "Ngày kết thúc phải sau ngày bắt đầu.",
        ];
    }
}

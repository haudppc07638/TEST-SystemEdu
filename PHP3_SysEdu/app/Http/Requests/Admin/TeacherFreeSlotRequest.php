<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TeacherFreeSlotRequest extends FormRequest
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
        return [
            'time_slots' => 'required|array',
            'time_slots.*' => 'exists:time_slots,id',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
        ];
    }

    public function messages()
    {
        return [
            'time_slots.required' => 'Vui lòng chọn ít nhất một ca học.',
            'time_slots.array' => 'Ca học phải là một mảng.',
            'time_slots.*.exists' => 'Một hoặc nhiều ca học không tồn tại.',
            'start_day.required' => 'Vui lòng chọn ngày bắt đầu.',
            'end_day.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_day.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];
    }
}

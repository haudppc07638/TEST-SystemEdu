<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TimeSlotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $timeSlotId = $this->route('id'); 

        return [
            'slot' => ['required','string','max:10',Rule::unique('time_slots', 'slot')->ignore($timeSlotId)],
            'start_time' => ['required'],
            'end_time' => ['required', 
                function ($attribute, $value, $fail) {
                    $startTime = $this->input('start_time');
                    if ($startTime >= $value) {
                        $fail('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'slot.required' => 'Ca thời gian không được để trống',
            'slot.string' => 'Ca thời gian phải là một chuỗi ký tự',
            'slot.max' => 'Ca thời gian không được vượt quá 10 ký tự',
            'slot.unique' => 'Ca thời gian đã tồn tại',
            'start_time.required' => 'Thời gian bắt đầu không được để trống',
            'end_time.required' => 'Thời gian kết thúc không được để trống',
       
        ];
    }
}

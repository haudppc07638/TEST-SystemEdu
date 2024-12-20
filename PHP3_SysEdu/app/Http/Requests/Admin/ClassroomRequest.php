<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $classroomId=$this->route('id');
        return [
            'code' => ['required', 'string', 'max:10', Rule::unique('classrooms')->ignore($classroomId)],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã phòng học không được để trống',
            'code.string' => 'Mã phòng học phải là một chuỗi ký tự',
            'code.max' => 'Mã phòng học không được vượt quá 10 ký tự',
            'code.unique' => 'Mã phòng học đã tồn tại',
            'capacity.required' => 'Sức chứa không được để trống',
            'capacity.integer' => 'Sức chứa phải là một số nguyên',
            'capacity.min' => 'Sức chứa phải lớn hơn 0',
        ];
    }
}
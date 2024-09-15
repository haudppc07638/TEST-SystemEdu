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
        ];
    }
//h
    public function messages(): array
    {
        return [
            'code.required' => 'Mã phòng học không được để trống',
            'code.string' => 'Mã phòng học phải là một chuỗi ký tự',
            'code.max' => 'Mã phòng học không được vượt quá 10 ký tự',
            'code.unique' => 'Mã phòng học đã tồn tại',
        ];
    }
}
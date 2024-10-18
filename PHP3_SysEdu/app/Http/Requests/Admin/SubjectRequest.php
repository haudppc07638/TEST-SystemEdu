<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subjectId = $this->route('id');

        return [
            'code' => ['required','string','max:15',Rule::unique('subjects')->ignore($subjectId) ],
            'name' => ['required','string','max:100',Rule::unique('subjects')->ignore($subjectId)],
            'credit' => 'required|numeric|max:10|min:1',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã môn học là bắt buộc.',
            'code.string' => 'Mã môn học phải là chuỗi ký tự.',
            'code.max' => 'Mã môn học không được vượt quá 15 ký tự.',
            'code.unique' => 'Mã môn học đã tồn tại.',
            'name.required' => 'Tên môn học là bắt buộc.',
            'name.string' => 'Tên môn học phải là chuỗi ký tự.',
            'name.max' => 'Tên môn học không được vượt quá 100 ký tự.',
            'name.unique' => 'Tên môn học đã tồn tại.',

            'credit.required' => 'Số tín chỉ không được để trống ',
            'credit.numeric' => 'Số tín chỉ phải là số ',
            'credit.max' => 'Số tín chỉ không được quá 10',
            'credit.min' => 'Số tín chỉ phải ít nhất 1',

            'description.required' => 'Vui lòng nhập mô tả.',
        ];
    }
}

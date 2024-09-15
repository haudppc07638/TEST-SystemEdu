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
            'code' => ['required','string','max:20',Rule::unique('subjects')->ignore($subjectId) ],
            'name' => ['required','string','max:100',Rule::unique('subjects')->ignore($subjectId)],
            'description' => 'required',
            'major_id' => 'required|exists:majors,id',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã môn học là bắt buộc.',
            'code.string' => 'Mã môn học phải là chuỗi ký tự.',
            'code.max' => 'Mã môn học không được vượt quá 20 ký tự.',
            'code.unique' => 'Mã môn học đã tồn tại.',
            'name.required' => 'Tên môn học là bắt buộc.',
            'name.string' => 'Tên môn học phải là chuỗi ký tự.',
            'name.max' => 'Tên môn học không được vượt quá 100 ký tự.',
            'name.unique' => 'Tên môn học đã tồn tại.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'major_id.required' => 'Mã chuyên ngành là bắt buộc.',
        ];
    }
}

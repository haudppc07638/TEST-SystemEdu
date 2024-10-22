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

        $rules = [
            'code' => ['required', 'string', 'max:15', Rule::unique('subjects')->ignore($subjectId)],
            'name' => ['required', 'string', 'max:100'],
            'credit' => 'required|numeric|max:10|min:1',
            'description' => 'required',
            'score_types' => 'required|array|min:1',
            'weights' => 'array',
            'prerequisites' => 'nullable',
        ];

        // Xác thực trọng số cho từng loại điểm đã chọn
        foreach ($this->input('score_types', []) as $scoreTypeId) {
            $rules['weights.' . $scoreTypeId] = 'required|numeric|min:0|max:100';
        }

        return $rules;
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

            'credit.required' => 'Số tín chỉ không được để trống.',
            'credit.numeric' => 'Số tín chỉ phải là số.',
            'credit.max' => 'Số tín chỉ không được quá 10.',
            'credit.min' => 'Số tín chỉ phải ít nhất 1.',

            'description.required' => 'Vui lòng nhập mô tả.',

            'score_types.required' => 'Bạn phải chọn ít nhất một loại điểm.',
            'score_types.array' => 'Các loại điểm phải là mảng.',
            'score_types.min' => 'Bạn phải chọn ít nhất một loại điểm.',

            'weights.required' => 'Trọng số là bắt buộc đối với loại điểm đã chọn.',
            'weights.*.numeric' => 'Trọng số phải là số.',
            'weights.*.min' => 'Trọng số không được nhỏ hơn 0.',
            'weights.*.max' => 'Trọng số không được lớn hơn 100.',
            'weights.*.required' => 'Vui lòng nhập trọng số điểm',
        ];
    }
}

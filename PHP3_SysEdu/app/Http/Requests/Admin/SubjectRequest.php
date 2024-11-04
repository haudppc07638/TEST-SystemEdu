<?php

namespace App\Http\Requests\Admin;

use App\Models\ScoreType;
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
        $rules = [
            'code' => ['required', 'string', 'max:15', Rule::unique('subjects')->ignore($this->route('id'))],
            'name' => ['required', 'string', 'max:100'],
            'credit' => 'required|numeric|min:1|max:10',
            'description' => 'required|string',
            'score_types' => 'required|array|min:1',
            'weights' => 'required|array',
            'prerequisites' => 'nullable|array',
            'sub_scores' => 'nullable|array', // Kiểm tra sub-scores
        ];

        foreach ($this->input('score_types', []) as $scoreTypeId) {
            $rules["weights.$scoreTypeId"] = 'required|numeric|min:0|max:100';

            if ($this->isMultiScoreType($scoreTypeId)) {
                $rules["sub_scores.$scoreTypeId"] = 'required|integer|min:1';
            }
        }

        return $rules;
    }

    // Hàm kiểm tra xem loại điểm có phải là 'multi' không
    private function isMultiScoreType($scoreTypeId): bool
    {
        $scoreType = ScoreType::find($scoreTypeId);
        return $scoreType && $scoreType->type === 'multi';
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

            'credit.required' => 'Số tín chỉ không được để trống.',
            'credit.numeric' => 'Số tín chỉ phải là số.',
            'credit.min' => 'Số tín chỉ phải ít nhất là 1.',
            'credit.max' => 'Số tín chỉ không được vượt quá 10.',

            'description.required' => 'Vui lòng nhập mô tả.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',

            'score_types.required' => 'Bạn phải chọn ít nhất một loại điểm.',
            'score_types.array' => 'Các loại điểm phải là mảng.',
            'score_types.min' => 'Bạn phải chọn ít nhất một loại điểm.',

            'weights.required' => 'Trọng số là bắt buộc đối với các loại điểm đã chọn.',
            'weights.array' => 'Trọng số không hợp lệ.',

            'weights.*.required' => 'Vui lòng nhập trọng số cho loại điểm này.',
            'weights.*.numeric' => 'Trọng số phải là một số.',
            'weights.*.min' => 'Trọng số không được nhỏ hơn 0.',
            'weights.*.max' => 'Trọng số không được lớn hơn 100.',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
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
        $subjectId = $this->route('id');

        return [
            'name' => 'required|string|max:100',
            'code' => ['required', 'string', 'max:20', Rule::unique('subjects')->ignore($subjectId)],
            'credit' => 'required|numeric|max:6|min:1',
            'description' => 'required|string|max:500',
            'score_types' => 'required|array|min:1',
            'weights' => 'required|array',
            'prerequisites' => 'nullable|array',
            'sub_scores' => 'nullable|array',
            'major_id'=> 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateTotalWeight($validator);
            $this->validatePrerequisites($validator);
        });
    }

    private function validateTotalWeight($validator)
    {
        $totalWeight = 0;
        foreach ($this->input('score_types', []) as $scoreTypeId) {
            $weight = floatval($this->input("weights.$scoreTypeId", 0));
            $totalWeight += $weight;
        }

        if (round($totalWeight, 2) !== 100.00) {
            $validator->errors()->add(
                'weights',
                'Tổng trọng số cho các loại điểm đã chọn phải bằng 100%.'
            );
        }
    }

    private function validatePrerequisites($validator)
    {
        $prerequisites = $this->input('prerequisites', []);
        $subject = $this->route('subject');

        if ($subject && in_array($subject->id, $prerequisites)) {
            $validator->errors()->add(
                'prerequisites',
                'Không thể chọn chính môn học này làm môn tiên quyết.'
            );
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên môn học không được để trống !',
            'name.string' => 'Tên môn học phải là 1 chuỗi !',
            'name.max' => 'Tên môn học không được quá 100 ký tự !',

            'code.required' => 'Mã môn học không được để trống !',
            'code.string' => 'Mã môn học phải là chuỗi !',
            'code.max' => 'Mã môn học không được quá 20 ký tự !',
            'code.unique' => 'Mã môn học đã tồn tại !',

            'credit.required' => 'Số tín chỉ không được để trống !',
            'credit.numeric' => 'Số tín chỉ phải là số !',
            'credit.max' => 'Số tín chỉ không được quá 6 !',
            'credit.min' => 'Số tín chỉ phải ít nhất 1 !',

            'description.required' => 'Mô tả không được để trống !',
            'description.string' => 'Mô tả phải là 1 chuỗi !',
            'description.max' => 'Mô tả không được quá 500 ký tự !',

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

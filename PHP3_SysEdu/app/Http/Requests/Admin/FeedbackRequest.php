<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'subject_class_id' => 'required|exists:subject_classes,id',
            'question_name' => 'required|array|min:1',
            'question_name.*' => 'string|max:255',
            'target' => 'required|in:student,employee',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'subject_class_id.required' => 'Vui lòng chọn lớp môn học.',
            'subject_class_id.exists' => 'Lớp môn học không hợp lệ.',
            'question_name.required' => 'Vui lòng nhập ít nhất một câu hỏi phản hồi.',
            'question_name.array' => 'Danh sách câu hỏi phản hồi phải là một mảng.',
            'question_name.*.string' => 'Mỗi câu hỏi phản hồi phải là chuỗi ký tự.',
            'question_name.*.max' => 'Câu hỏi phản hồi không được vượt quá 255 ký tự.',
            'target.required' => 'Vui lòng chọn đối tượng phản hồi.',
            'target.in' => 'Đối tượng phản hồi không hợp lệ.',
        ];
    }
}

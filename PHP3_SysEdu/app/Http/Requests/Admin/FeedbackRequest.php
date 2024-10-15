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
        return true; // Cho phép tất cả người dùng thực hiện yêu cầu này
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'subject_class_id' => 'required|exists:subject_classes,id',
        ];

        if ($this->isMethod('post') && $this->routeIs('admin.feedbacks.store')) {
            // Validation cho admin khi tạo phản hồi
            $rules['admin_feedback'] = 'required|max:1000';
        } elseif ($this->isMethod('post') && $this->routeIs('submitStudentFeedback')) {
            // Validation cho học sinh khi gửi phản hồi
            $rules['student_feedback'] = 'required|max:1000';
            $rules['rating'] = 'required|in:Xuất sắc,Tốt,Khá,Trung bình,Yếu';
        }

        return $rules;
    }


    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'admin_feedback.required' => 'Phản hồi là bắt buộc.',
            'admin_feedback.max' => 'Phản hồi không được vượt quá: 1000 ký tự.',
            'student_feedback.required' => 'Phản hồi không được bỏ trống',
            'student_feedback.max' => 'Phản hồi không được vượt quá: 1000 ký tự',
            'rating.required' => 'Mức đánh giá không được bỏ trống',
            'rating.in' => 'Mức đánh giá không hợp lệ.',
            'subject_class_id.required' => 'Lớp môn là bắt buộc.',
            'subject_class_id.exists' => 'Lớp môn không tồn tại.',
        ];
    }
}                   

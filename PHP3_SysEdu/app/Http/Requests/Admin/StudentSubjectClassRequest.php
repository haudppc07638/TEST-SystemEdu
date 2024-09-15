<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentSubjectClassRequest extends FormRequest
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
        return [
            'midterm_score' => 'numeric|min:0|max:10',
            'final_score' => 'numeric|min:0|max:10',
        ];
    }
    public function messages(){
        return [
            'midterm_score.numeric' => 'Điểm phải nhập bằng số!',
            'midterm_score.min' => 'Điểm không nhập nhỏ hơn 0',
            'midterm_score.max' => 'Điểm không nhập lớn hơn 10',
            'final_score.numeric' => 'Điểm phải nhập bằng số!',
            'final_score.min' => 'Điểm không nhập nhỏ hơn 0',
            'final_score.max' => 'Điểm không được nhập lớn hơn 10',
        ];
        
    }
}

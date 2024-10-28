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
            'scores.*' => 'nullable|numeric|min:0|max:10',
        ];
    }

    public function messages()
    {
        return [

            'scores.*.numeric' => 'Điểm phải nhập bằng số!',
            'scores.*.min' => 'Điểm không được nhỏ hơn 0.',
            'scores.*.max' => 'Điểm không được lớn hơn 10.',
        ];
    }
}

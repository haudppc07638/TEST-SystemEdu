<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScoreTypeRequest extends FormRequest
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
    public function rules()
    {
        $scoreTypeId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:100',Rule::unique('score_types')->ignore( $scoreTypeId)],
            'type' => 'required|in:single,multi',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên loại điểm là bắt buộc.',
            'name.string' => 'Tên loại điểm phải là một chuỗi.',
            'name.max' => 'Tên loại điểm không được quá 100 ký tự.',
            'name.unique' => 'Loại điểm đã tồn tại.',

            'type.required' => 'Loại điểm không được để trống',
            'type.in' => 'Loại điểm không hợp lệ',
        ];
    }
}

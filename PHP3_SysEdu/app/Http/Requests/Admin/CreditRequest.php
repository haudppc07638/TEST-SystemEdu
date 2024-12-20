<?php

namespace App\Http\Requests\Admin;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'vat'   => 'required|numeric|min:0|max:100',        ];
    }

    public function messages(): array
    {
        return [
            'price.required' => 'Giá tiền không được để trống',
            'price.numeric' => 'Giá tiền phải là số',
            'price.min' => 'Giá tiền phải lớn hơn 0',
            
            'vat.numeric' => 'Tỷ lệ tăng phải là số',
            'vat.min' => 'Tỷ lệ tăng phải lớn hơn 0',
        ];
    }
}

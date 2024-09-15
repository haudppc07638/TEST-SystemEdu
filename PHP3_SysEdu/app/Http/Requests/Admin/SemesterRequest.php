<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        $semmesterId= $this->route('id');
        return [
            'block' => ['required', 'string', 'max:10',Rule::unique('semesters')->ignore( $semmesterId)],
            'year' => ['required'], 
        ];
    }

    public function messages(): array
    {
        return [
            'block.required' => 'kỳ không được để trống',
           'block.unique'=>'tên kỳ không được để trùng ',
            'block.max' => 'Kỳ không được vượt quá 10 ký tự',
            'year.required' => 'Năm không được để trống', 
        ];
    }
}

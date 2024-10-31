<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSection extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'section_name' => 'required|max:255|unique:sections',
        ];
    }
    public function messages(): array
    {
        return [
            'section_name.required' => 'يجب إادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل بالفعل',
        ];
    }
}

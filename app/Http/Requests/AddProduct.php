<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProduct extends FormRequest
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
            'product_name' => 'required|max:255|unique:products,product_name',
            'section_id' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'product_name.required' => 'يجب إدخال اسم المنتج',
                'product_name.unique' => 'هذا القسم مسجل بالفعل',
                'section_id.required' => 'يجب إدخال مسلسل القسم',

            ];
    }
}

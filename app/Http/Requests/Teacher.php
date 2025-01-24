<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Teacher extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => 'required',
            'phone'     => 'required|digits:11|unique:users,phone',
            'password'  => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'أدخل الاسم',
            'phone.required'    => 'ادخل رقم الهاتف',
            'phone.digits' => 'يجب ان يكون رقم الهاتف 11 رقم',
            'phone.unique'  => 'رقم الهاتف موجود بالفعل',
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class TeacherUpdate extends FormRequest
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
            'name'          => 'required',
            'phone'         => 'required|digits:11|unique:users,phone,'.$this->id,
            'password'      => 'nullable|min:6',
            'image'         => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'أدخل الاسم',
            'phone.required'    => 'ادخل رقم الهاتف',
            'phone.digits'      => 'يجب ان يكون رقم الهاتف 11 رقم',
            'phone.unique'      => 'رقم الهاتف موجود بالفعل',
        ];
    }
}

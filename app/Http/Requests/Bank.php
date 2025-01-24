<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Bank extends FormRequest
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
            'subject_id'    => 'required|exists:subjects,id',
            'chapter_id'    => 'nullable|exists:chapters,id',
            'question'      => 'required|string',
            'answer'        => 'required|string',
        ];
    }
}

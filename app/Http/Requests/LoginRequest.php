<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'phone' => 'required|string',
            'password' => 'required|string'
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'phone.required' => 'The phone field is required.'
        ];
    }
}
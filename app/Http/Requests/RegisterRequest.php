<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'gender' => 'required|string',
            'password' => 'required|string|min:6',
            'type_utilisateur' => 'required|string|in:Patient,Medecin,Administrateur,Autre'
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => 'The gender field is required.'
        ];
    }
}

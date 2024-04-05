<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'gender' => 'required|string',
            'password' => 'required|string|min:6',
            'type_utilisateur' => 'required|string|in:Patient,Medecin,Administrateur,Autre',
            'avatar' => 'nullable|image|max:2048',
        ];
    }
    public function store(Request $request)
    {
        $request['password'] = Hash::make($request->password);

        $user = User::create($request->all());

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = $user->id . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $avatarName);
            $user->avatar = 'avatars/' . $avatarName;
            $user->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur enregistré avec succès',
            'data' => [
                'user' => $user,
            ],
            'code' => 201
        ]);
    }
    public function messages()
    {
        return [
            'gender.required' => 'The gender field is required.'
        ];
    }
}

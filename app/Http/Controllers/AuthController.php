<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request['password'] = Hash::make($request->password);

        $user = User::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur enregistré avec succès',
            'data' => [
                'user' => $user,
            ],
            'code' => 201
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        // Check if the user logged in using email or phone number
        if (!auth()->attempt($request->only('email', 'password')) && !auth()->attempt($request->only('phone', 'password'))) {
            return response()->json(['message', 'Identifiants incorrects'], 401);
        }
        $user = auth()->user();
        $token = $user->createToken('AuthToken')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur connecté avec succès',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
            'code' => 200
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 'success',
            'message' => 'Déconnexion réussie',
            'code' => 200
        ]);
    }
}

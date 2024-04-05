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
        return $request->store($request);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:191',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages(),
            ]);
        } else {
            $user = User::where('phone', $request->phone)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    "data" => [
                        'errors' => $validator->messages(),
                        "error" => true,
                        'status' => 401,
                        'message' => 'These credentials do not match our records',
                    ]
                ]);
            } else {
                $token =  $user->createToken($user->phone . '_Token', [''])->plainTextToken;
                return response()->json([
                    "data" => [
                        'user' => $user,
                        'token' => $token,
                        'message' => 'Logged in Successfully',
                    ]
                ]);
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "data" => [
                "error" => true,
                'status' => 200,
                'message' => 'Logged Out Successfully'
            ]
        ]);
    }

    public function checkAuthenticated(Request $request)
    {
        return response()->json([
            'authenticated' => auth()->check()
        ]);
    }
}

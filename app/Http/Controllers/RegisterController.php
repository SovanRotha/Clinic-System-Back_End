<?php

namespace App\Http\Controllers;

use App\Models\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function Register(Request $request){
        $validate = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:register,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string',
            'role' => 'string'
        ]);

        $user = RegisterModel::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'phone_number' => $validate['phone_number'],
            'role' => $validate['role']
        ]);

        return response()->json([
            'message' => 'register successfully',
            'user' => $user
        ]);
    }

   public function login(Request $request)
{
    $validate = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    $user = RegisterModel::where('email', $validate['email'])->first();

    if (!$user || !Hash::check($validate['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token
    ], 200);
}
}

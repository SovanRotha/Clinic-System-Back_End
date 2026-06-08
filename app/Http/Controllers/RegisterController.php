<?php

namespace App\Http\Controllers;

use App\Models\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function Register(Request $request){
        try {
            $validate = $request->validate([
                'name' => 'required|string|max:250',
                'email' => 'required|email|max:250|unique:register,email',
                'password' => 'required|string|min:6',
                'phone_number' => 'required|string',
                'role' => 'nullable|string'
            ]);

            $profilePath = null;

            // Accept either an uploaded file (multipart/form-data) or a profile URL in JSON
            if ($request->hasFile('profile')) {
                $request->validate([
                    'profile' => 'image|mimes:jpg,jpeg,png|max:2048',
                ]);

                $profilePath = $request->file('profile')->store('profiles', 'public');
            } elseif ($request->filled('profile')) {
                // If client provided a URL string for profile, validate it is a URL and store the URL
                $request->validate([
                    'profile' => 'url',
                ]);

                $profilePath = $request->input('profile');
            }


            $user = RegisterModel::create([
                'name' => $validate['name'],
                'email' => $validate['email'],
                'password' => Hash::make($validate['password']),
                'profile' => $profilePath,
                'phone_number' => $validate['phone_number'],
                'role' => $validate['role'] ?? 'patient'
            ]);

            $role = $validate['role'] ?? 'patient';

           
            //  if ($role === 'patient') {
            //      $user->patient()->create([
            //          'patient_code' => 'PAT-' . $user->id,
            //      ]);
            // }

            if($role === 'patient'){
                $user->patient()->create([
                    'patient_code' => 'PAT-' . $user->id,
                ]);
            }
            

            return response()->json([
                'message' => 'register successfully',
                'user' => $user,
                // 'profile' => $profilePath
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
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

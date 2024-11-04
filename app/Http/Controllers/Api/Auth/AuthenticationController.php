<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'username' => 'required|string|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $referral_code = Str::random(10);

        $user = User::create([
            'role_id' => $request->role_id,
            'rank_id' => 1,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referral_code
        ]);

        $userToken = $user->createToken('user-token')->plainTextToken;

        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Berhasil Registrasi',
            'data' => $user,
            'token' => $userToken,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'username' => 'required|min:4|string',
            'password' => 'required|min:6',
        ]);

        $user = User::whereUsername($request->username)->where('role_id', $request->role_id)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'code' => 422,
                'status' => false,
                'message' => 'Data salah!',
            ], 422);
        }

        $userToken = $user->createToken('user-token')->plainTextToken;

        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil Login',
            'data' => $user,
            'token' => $userToken,
        ], 200);
    }

    public function user()
    {
        $user = Auth::user();

        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil',
            'data' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil Logout',
        ], 200);
    }
}
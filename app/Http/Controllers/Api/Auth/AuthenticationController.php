<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Eksternal;
use App\Models\Leaderboard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthenticationController extends Controller
{
    // Registrasi
    public function register(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|min:4',
            'username' => 'required|string|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'identity_number' => 'required|digits_between:6,16|numeric|unique:users',
            'role_id' => 'required|numeric',
        ]);

        // Validasi tambahan Role Eksternal
        if ($request->role_id == 2) {
            // Validasi Input
            $request->validate([
                'company' => 'required|string|min:4',
                'position' => 'required|string|min:4',
            ]);
        }

        // Membuat kode referral random
        $referral_code = Str::random(10);

        // Membuat akun user
        $user = User::create([
            'role_id' => $request->role_id,
            'rank_id' => 1,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'identity_number' => $request->identity_number,
            'referral_code' => $referral_code,
        ]);

        // Membuat data eksternal
        if ($request->role_id == 2) {
            Eksternal::create([
                'user_id' => $user->id,
                'agency/company' => $request->company,
                'position' => $request->position,
            ]);
        }

        // Membuat leaderboard
        Leaderboard::create([
            'user_id' => $user->id,
            'rank_id' => 1,
            'start_date' => Carbon::now()->format('Y-m-d'),
        ]);

        // Membuat token
        $userToken = $user->createToken('user-token')->plainTextToken;

        // Mengembalikan response API
        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Berhasil Registrasi',
            'data' => $user,
            'token' => $userToken,
        ], 201);
    }

    // Login
    public function login(Request $request)
    {
        // Validasi Input
        $request->validate([
            'role_id' => 'required',
            'username' => 'required|min:4|string',
            'password' => 'required|min:6',
        ]);

        // Mengecek apakah data sesuai dengan database
        $user = User::whereUsername($request->username)->where('role_id', $request->role_id)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'code' => 422,
                'status' => false,
                'message' => 'Data salah!',
            ], 422);
        }

        // Membuat token
        $userToken = $user->createToken('user-token')->plainTextToken;

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil Login',
            'data' => $user,
            'token' => $userToken,
        ], 200);
    }

    // Mengambil data user login
    public function profile()
    {
        // Mengambil data user
        $user = Auth::user();

        // Mengambil data user Role Eksternal
        if ($user->role_id == 2) {
            $user = User::with('eksternal')->where('id', $user->id)->get();
        }

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil',
            'data' => $user,
        ], 200);
    }

    // Ubah profile
    public function editProfile(Request $request)
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // validasi input
        $request->validate([
            'name' => 'required|min:4',
            'username' => [
                'required',
                'string',
                'min:4',
                Rule::unique('users')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId)
            ],
            'identity_number' => [
                'required',
                'digits_between:6,16',
                'numeric',
                Rule::unique('users')->ignore($userId)
            ],
        ]);

        // Validasi tambahan Role Eksternal
        if (Auth::user()->role_id == 2) {
            // Validasi Input
            $request->validate([
                'company' => 'required|string|min:4',
                'position' => 'required|string|min:4',
            ]);
        }

        // Update User Profile
        $user = User::findOrFail($userId);
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'identity_number' => $request->identity_number,
        ]);

        // Update tambahan Role Eksternal
        if (Auth::user()->role_id == 2) {
            $userEksternal = Eksternal::where('user_id', $userId);
            $userEksternal->update([
                'agency/company' => $request->company,
                'position' => $request->position,
            ]);

            // Mengambil data user Role Eksternal
            $user = User::with('eksternal')->where('id', $userId)->get();
        }

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $user,
            'message' => 'Berhasil Update Profile',
        ], 200);
    }

    // Ubah Password
    public function editPassword(Request $request)
    {
        // Mengambil id user
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            // Mengembalikan response API Gagal
            return response([
                'code' => 400,
                'status' => false,
                'message' => 'Password lama tidak sesuai',
            ], 400);
        }

        // Jika password sesuai
        $user = User::findOrFail($user->id);
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil Update Password',
        ], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        // Menghapus token
        $request->user()->tokens()->delete();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'message' => 'Berhasil Logout',
        ], 200);
    }
}
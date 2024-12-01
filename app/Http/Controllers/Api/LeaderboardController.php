<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    // Mengambil 3 data teratas
    public function topThree()
    {
        // Mengambil data leaderboard
        $data = Leaderboard::join('users', 'leaderboards.user_id', '=', 'users.id')
            ->with('rank')
            ->orderBy('users.total_exp', 'desc')
            ->limit(3)
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Top 3 Leaderboard',
        ], 200);
    }

    // Mengambil 100 data teratas
    public function leaderboard()
    {
        // Mengambil data leaderboard
        $data = Leaderboard::join('users', 'leaderboards.user_id', '=', 'users.id')
            ->with('rank')
            ->orderBy('users.total_exp', 'desc')
            ->limit(100)
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Top 100 Leaderboard',
        ], 200);
    }

    // Mengambil leaderboard user
    public function userLeaderboard()
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil data leaderboard
        $data = Leaderboard::with(['user', 'rank'])
            ->where('user_id', $userId)->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil User Leaderboard',
        ], 200);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    // Mengambil 3 data teratas
    public function topThree()
    {
        // Mengambil data leaderboard
        $data = Leaderboard::join('users', 'leaderboards.user_id', '=', 'users.id')
            ->with(['user', 'rank'])
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
}
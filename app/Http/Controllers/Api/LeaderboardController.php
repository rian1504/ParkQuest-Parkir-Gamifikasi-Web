<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    // Mengambil 3 data teratas
    public function topThree()
    {
        // Mengambil data leaderboard
        $data = Leaderboard::with(['user', 'rank'])
            ->whereHas('user', function (Builder $query) {
                $query->orderByDesc('total_exp');
            })
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
        $data = Leaderboard::with(['user', 'rank'])
            ->whereHas('user', function (Builder $query) {
                $query->orderByDesc('total_exp');
            })
            ->skip(3)
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
            ->where('user_id', $userId)->first();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil User Leaderboard',
        ], 200);
    }
}
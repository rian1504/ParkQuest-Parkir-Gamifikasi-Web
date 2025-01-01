<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    // Mengambil 3 data teratas
    public function topThree()
    {
        // Mengambil data leaderboard
        $data = Leaderboard::with(['user', 'rank'])
            ->join('users', 'leaderboards.user_id', '=', 'users.id') // Join dengan tabel users
            ->orderByDesc('leaderboards.rank_id') // Urutkan berdasarkan rank_id tertinggi
            ->orderByDesc('users.total_exp') // Urutkan berdasarkan total_exp tertinggi
            ->orderBy('leaderboards.updated_at') // Urutkan berdasarkan updated_at terlama
            ->limit(3) // Ambil 3 data teratas
            ->get(['leaderboards.*']); // Ambil kolom dari tabel leaderboard

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
            ->join('users', 'leaderboards.user_id', '=', 'users.id') // Join dengan tabel users
            ->orderByDesc('leaderboards.rank_id') // Urutkan berdasarkan rank_id tertinggi
            ->orderByDesc('users.total_exp') // Urutkan berdasarkan total_exp tertinggi
            ->orderBy('leaderboards.updated_at') // Urutkan berdasarkan updated_at terlama
            ->skip(3)
            ->limit(100)
            ->get(['leaderboards.*']); // Ambil kolom dari tabel leaderboard

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

        // // Mengambil semua data leaderboard dan mengurutkannya
        // $leaderboard = Leaderboard::with(['user', 'rank'])
        //     ->join('users', 'leaderboards.user_id', '=', 'users.id') // Join dengan tabel users
        //     ->orderByDesc('leaderboards.rank_id') // Urutkan berdasarkan rank_id tertinggi
        //     ->orderByDesc('users.total_exp') // Urutkan berdasarkan total_exp tertinggi
        //     ->orderBy('leaderboards.updated_at') // Urutkan berdasarkan updated_at terlama
        //     ->get(['leaderboards.*']); // Ambil kolom dari tabel leaderboard

        // // Mencari posisi user di leaderboard
        // $userPosition = null;
        // foreach ($leaderboard as $index => $entry) {
        //     if ($entry->user_id == $userId) {
        //         $userPosition = $index + 1; // Posisi dimulai dari 1, bukan 0
        //         break;
        //     }
        // }

        // Optimasi query untuk mencari posisi user di leaderboard
        $userPosition = DB::select('
    SELECT COUNT(*) + 1 AS position
    FROM leaderboards
    JOIN users ON leaderboards.user_id = users.id
    WHERE (leaderboards.rank_id, users.total_exp, leaderboards.updated_at) > (
        SELECT leaderboards.rank_id, users.total_exp, leaderboards.updated_at
        FROM leaderboards
        JOIN users ON leaderboards.user_id = users.id
        WHERE leaderboards.user_id = ?
    )
', [$userId])[0]->position;

        // Mengambil data leaderboard
        $data = Leaderboard::with(['user', 'rank'])
            ->where('user_id', $userId)->first();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => [
                'user_data' => $data,
                'position' => $userPosition,
            ],
            'message' => 'Berhasil Mengambil User Leaderboard',
        ], 200);
    }
}

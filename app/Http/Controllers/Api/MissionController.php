<?php

namespace App\Http\Controllers\Api;

use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MissionCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    // Mengambil data user missions
    public function index()
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil data user missions
        $data = UserMission::where('user_id', $userId)->with('mission')->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Misi',
        ], 200);
    }

    // Daily Login
    public function dailyLogin()
    {
        // Mengambil data user
        $userId = Auth::user()->id;

        // Ambil semua misi daily
        $dailyMissions = Mission::whereHas('mission_category', function ($query) {
            $query->where('mission_category_name', 'Daily');
        })->get();

        // Cari misi yang sesuai dengan streak pengguna
        $currentStreak = UserMission::where('user_id', $userId)
            ->where('status', 'in progress')
            ->value('streak') ?? 0;

        $currentMission = $dailyMissions->first(function ($mission) use ($currentStreak) {
            return $mission->day_start <= $currentStreak + 1 && $mission->day_end >= $currentStreak + 1;
        });

        if (!$currentMission) {
            return response([
                'code' => 404,
                'status' => false,
                'message' => 'Tidak ada misi yang sesuai dengan streak saat ini.',
            ], 404);
        }

        // Cari user mission yang sudah ada berdasarkan user_id
        $userMission = UserMission::where('user_id', $userId)->first();

        // Jika tidak ada user mission, buat baru
        if (!$userMission) {
            $userMission = new UserMission();
            $userMission->user_id = $userId;
        }

        // Ambil tanggal hari ini
        $currentDate = now()->startOfDay();

        // Cek apakah streak bukan 0
        if ($userMission->streak != 0) {
            // Cek apakah sudah login hari ini
            if ($userMission->updated_at && $userMission->updated_at->startOfDay()->equalTo($currentDate)) {
                return response([
                    'code' => 400,
                    'status' => false,
                    'message' => 'Anda sudah login hari ini.',
                ], 400);
            }
        }

        // Tingkatkan streak
        $userMission->streak += 1;

        // Cari hadiah sesuai streak
        $reward = $currentMission->reward;

        // Berikan hadiah ke pengguna
        $user = User::findOrFail($userId);
        $user->increment('coin', $reward->reward_amount);

        // Tandai misi selesai jika streak mencapai batas maksimum
        if ($userMission->streak === 7) {
            $userMission->status = 'completed';
        } else {
            $userMission->status = 'in progress';
        }

        // Simpan minggu saat ini
        $userMission->week_number = now()->weekOfYear;

        // Simpan data user mission
        $userMission->mission_id = $currentMission->id;
        $userMission->updated_at = $currentDate;
        $userMission->save();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $userMission,
            'message' => 'Berhasil Klaim Daily Login',
        ], 200);
    }
}
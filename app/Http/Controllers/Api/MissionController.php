<?php

namespace App\Http\Controllers\Api;

use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MissionCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    // Daily Login
    public function dailyLogin()
    {
        // Mengambil data user
        $userId = Auth::user()->id;

        // Ambil semua misi daily
        // $dailyMission = MissionCategory::join('missions', 'mission_categories.id', '=', 'missions.mission_category_id')
        //     ->where('mission_category_name', 'Daily')->get();
        $dailyMission = Mission::where('mission_category_id', 1)->get();

        // Ambil user mission
        $userMission = UserMission::firstOrNew(['user_id' => $userId, 'mission_id' => $dailyMission->first()->id]);

        // Cek terakhir login
        $lastLogin = $userMission->updated_at ? $userMission->updated_at->startOfDay() : null;

        // Ambil tanggal hari ini
        $currentDate = now()->startOfDay();

        // Cek apakah sudah login hari ini
        if ($lastLogin && $lastLogin->equalTo($currentDate)) {
            return response([
                'code' => 400,
                'status' => false,
                'message' => 'Anda sudah login hari ini.',
            ], 400);
        }

        // Menambahkan streak
        if ($lastLogin && $lastLogin->diffInDays($currentDate) === 1) {
            $userMission->streak += 1;
        } else {
            $userMission->streak = 1;
        }

        // Cari hadiah sesuai streak
        $currentMission = $dailyMission->first(function ($mission) use ($userMission) {
            return $mission->day_start <= $userMission->streak && $mission->day_end >= $userMission->streak;
        });

        if ($currentMission) {
            $reward = $currentMission->reward;
            // $reward = $currentMission->mission->reward;

            // Berikan hadiah ke pengguna
            $user = User::findOrFail($userId);
            $user->increment('coin', $reward->reward_amount);

            // Tandai misi selesai jika streak mencapai batas maksimum
            if ($userMission->streak === 7) {
                $userMission->status = 'completed';
            } else {
                $userMission->status = 'in progress';
            }
        }

        // Simpan minggu saat ini
        $userMission->week_number = now()->weekOfYear;

        // Simpan data user mission
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

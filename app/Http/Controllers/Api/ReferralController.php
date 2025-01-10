<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Mission;
use App\Models\RewardType;
use App\Models\UserMission;
use Illuminate\Http\Request;
use App\Models\ReferralUsage;
use App\Models\MissionCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    // Membaca data referral
    public function index()
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil kode referral
        $referralCode = User::where('id', $userId)->first()->referral_code;

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $referralCode,
            'message' => 'Berhasil Mengambil Referral Code User',
        ], 200);
    }

    // Memasukkan data referral
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'referral_code' => 'required|string|min:4|max:10'
        ]);

        // Mengambil id user
        $usageUserId = Auth::user()->id;

        // Mengambil data user berdasarkan kode yang dimasukkan
        $referralCodeUser = User::where('referral_code', $request->referral_code);

        // Mengecek apakah kode yang dimasukkan valid atau tidak
        // Jika kode referral tidak ada
        if (!$referralCodeUser->exists()) {
            // Mengembalikan response API Gagal
            return response([
                'code' => 400,
                'status' => false,
                'message' => 'Kode Referral Tidak Valid',
            ], 400);
        }
        // Jika kode referral ada
        else {
            // Mengambil id user berdasarkan kode yang dimasukkan
            $referralCodeUserId = $referralCodeUser->first()->id;

            // Mengambil data kode referral yang sudah dimasukkan
            $referralUsage = ReferralUsage::where('referral_code_user_id', $referralCodeUserId)->where('usage_user_id', $usageUserId)->exists();

            // Jika user memasukkan kode referralnya sendiri
            if ($referralCodeUserId == $usageUserId) {
                // Mengembalikan response API Gagal
                return response([
                    'code' => 400,
                    'status' => false,
                    'message' => 'Gunakan Kode Referral Milik Orang Lain',
                ], 400);
            }
            // Jika kode referral sudah pernah dimasukkan sebelumnya
            elseif ($referralUsage) {
                // Mengembalikan response API Gagal
                return response([
                    'code' => 400,
                    'status' => false,
                    'message' => 'Kode Referral Sudah Digunakan!',
                ], 400);
            } else {
                // Mengambil recommendation reward id
                $referralRewardId = RewardType::join('rewards', 'rewards.reward_type_id', '=', 'reward_types.id')
                    ->where('reward_type_name', 'coin')->where('reward_amount', 10)->first()->id;

                // Menambahkan coin user yang memiliki kode
                $user = User::findOrFail($referralCodeUserId);
                $user->increment('coin', 10);

                // Membuat data referral usage
                $data = ReferralUsage::create([
                    'referral_code_user_id' => $referralCodeUserId,
                    'usage_user_id' => $usageUserId,
                    'reward_id' => $referralRewardId
                ]);

                // Ambil semua misi lifetime
                $mission = Mission::whereHas('mission_category', function ($query) {
                    $query->where('mission_category_name', 'Lifetime');
                })->first();

                // Ambil user mission
                $userMission = UserMission::firstOrNew(['user_id' => $referralCodeUserId, 'mission_id' => $mission->id]);

                // Tingkatkan streak
                $userMission->streak += 1;

                // Jika streak mencapai 3
                if ($userMission->streak >= 3) {
                    $userMission->status = 'completed';

                    // Berikan hadiah kepada pengguna
                    $reward = $mission?->reward;
                    $user = User::findOrFail($referralCodeUserId);
                    $user->increment('coin', $reward->reward_amount);
                } else {
                    $userMission->status = 'in progress';
                }

                // Simpan user mission
                $userMission->save();

                // Mengembalikan response API
                return response([
                    'code' => 200,
                    'status' => true,
                    'data' => $data,
                    'message' => 'Berhasil Memasukkan Referral Code User',
                ], 200);
            }
        }
    }
}

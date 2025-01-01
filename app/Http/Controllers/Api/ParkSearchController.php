<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Reward;
use App\Models\ParkArea;
use App\Models\ParkData;
use App\Models\RewardType;
use App\Models\UserMission;
use Illuminate\Http\Request;
use App\Models\MissionCategory;
use App\Models\ParkRecommendation;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use Illuminate\Support\Facades\Auth;
use App\Models\ParkRecommendationAccepted;

class ParkSearchController extends Controller
{
    // Mengambil area parkir
    public function parkArea()
    {
        // Mengambil data area parkir
        $data = ParkArea::all();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Area Parkir',
        ], 200);
    }

    // Mengambil data parkir berdasarkan area yang dipilih
    public function parkData(ParkArea $parkArea)
    {
        $data = ParkData::where('park_area_id', $parkArea->id)->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'dataParkArea' => $parkArea,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Parkir',
        ], 200);
    }

    // Mengambil data rekomendasi berdasarkan area yang dipilih
    public function parkRecommendation(ParkArea $parkArea)
    {
        // Mengambil id user login
        $userId = Auth::user()->id;

        $data = ParkRecommendation::where('park_area_id', $parkArea->id)
            ->with('user')
            ->where('capacity', '>', 0)
            ->where('user_id', '!=', $userId)
            ->latest()
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Rekomendasi Parkir',
        ], 200);
    }

    // Mengambil detail data rekomendasi berdasarkan area yang dipilih
    public function parkRecommendationDetail(ParkRecommendation $parkRecommendation)
    {
        // Mengambil id park recommendation
        $parkRecommendationId = $parkRecommendation->id;

        // Mengambil detail data park recommendation
        $data = ParkRecommendation::with('user')->findOrFail($parkRecommendationId);

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Detail Data Rekomendasi Parkir',
        ], 200);
    }

    // Menerima rekomendasi parkir
    public function parkRecommendationAccepted(ParkRecommendation $parkRecommendation)
    {
        // Mengambil user yang merekomendasi
        $recommendationUserId = $parkRecommendation->user_id;

        // Mengambil recommendation id
        $parkRecommendationId = $parkRecommendation->id;

        // Mengambil user yang menerima rekomendasi
        $acceptantUserId = Auth::user()->id;

        // Mengecek apakah sudah pernah menerima rekomendasi atau belum
        $cekRecommendation = ParkRecommendationAccepted::where('park_recommendation_id', $parkRecommendationId)
            ->where('acceptant_user_id', $acceptantUserId)
            ->exists();

        if ($cekRecommendation) {
            // Mengembalikan response API Gagal
            return response([
                'code' => 400,
                'status' => false,
                'message' => 'Hanya Bisa Menerima 1x Rekomendasi',
            ], 400);
        } else {
            // Mengambil acceptant reward id
            $acceptantRewardId = RewardType::join('rewards', 'rewards.reward_type_id', '=', 'reward_types.id')
                ->where('reward_type_name', 'EXP')->where('reward_amount', 20)->first()->id;

            // Menambahkan exp ke user yang menerima rekomendasi
            $acceptantUser = User::findOrFail($acceptantUserId);
            $acceptantUser->increment('total_exp', 20);

            // Update rank
            $acceptantUser->updateRank();

            // Mengambil recommendation reward id
            $recommendationRewardId = RewardType::join('rewards', 'rewards.reward_type_id', '=', 'reward_types.id')
                ->where('reward_type_name', 'EXP')->where('reward_amount', 100)->first()->id;

            // Menambahkan exp ke user yang merekomendasi
            $recommendationUser = User::findOrFail($recommendationUserId);
            $recommendationUser->increment('total_exp', 100);

            // Update rank
            $recommendationUser->updateRank();

            // Mengurangi kapasitas parkir
            $parkRecommendation->decrement('capacity', 1);

            // Membuat data berhasil menerima rekomendasi
            $data = ParkRecommendationAccepted::create([
                'park_recommendation_id' => $parkRecommendationId,
                'acceptant_user_id' => $acceptantUserId,
                'acceptant_reward_id' => $acceptantRewardId,
                'recommendation_reward_id' => $recommendationRewardId,
            ]);

            // Mengambil id rank user
            $rankId = User::where('id', $recommendationUserId)->first()->rank_id;

            // Ambil misi weekly
            $mission = Mission::whereHas('mission_category', function ($query) {
                $query->where('mission_category_name', 'Weekly');
            })
                ->where('rank_id', $rankId)
                ->first();

            // Ambil user mission
            $userMission = UserMission::firstOrNew(['user_id' => $recommendationUserId, 'mission_id' => $mission->id]);

            // Tingkatkan streak
            $userMission->streak += 1;

            // Cek apakah misi sudah selesai atau belum
            if ($userMission->status == 'in progress') {
                // Jika streak mencapai target
                if (
                    $mission->rank_id == 1 and $userMission->streak >= 5 or $mission->rank_id == 2 and $userMission->streak >= 7 or
                    $mission->rank_id == 3 and $userMission->streak >= 9 or $mission->rank_id == 4 and $userMission->streak >= 11 or
                    $mission->rank_id == 5 and $userMission->streak >= 15
                ) {
                    $userMission->status = 'completed';

                    // Berikan hadiah kepada pengguna
                    $reward = $mission?->reward;
                    $user = User::findOrFail($recommendationUserId);
                    $user->increment('total_exp', $reward->reward_amount);

                    // Update rank
                    $user->updateRank();
                } else {
                    $userMission->status = 'in progress';
                }
            }

            // Simpan minggu saat ini
            $userMission->week_number = now()->weekOfYear;

            // Simpan user mission
            $userMission->save();

            // Mengembalikan response API
            return response([
                'code' => 200,
                'status' => true,
                'data' => $data,
                'message' => 'Berhasil Menerima Rekomendasi Parkir',
            ], 200);
        }
    }
}

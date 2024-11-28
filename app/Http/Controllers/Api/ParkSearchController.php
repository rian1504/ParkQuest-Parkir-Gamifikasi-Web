<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkArea;
use App\Models\ParkData;
use App\Models\ParkRecommendation;
use App\Models\ParkRecommendationAccepted;
use App\Models\Reward;
use App\Models\RewardType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Mengambil semua data rekomendasi
    public function parkRecommendation()
    {
        $data = ParkRecommendation::where('capacity', '>', 0)->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Rekomendasi Parkir',
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

        // Mengambil acceptant reward id
        $acceptantRewardId = RewardType::join('rewards', 'rewards.reward_type_id', '=', 'reward_types.id')
            ->where('reward_type_name', 'EXP')->where('reward_amount', 20)->first()->id;

        // Menambahkan exp ke user yang menerima rekomendasi
        $acceptantUser = User::findOrFail($acceptantUserId);
        $acceptantUser->increment('total_exp', 20);

        // Mengambil recommendation reward id
        $recommendationRewardId = RewardType::join('rewards', 'rewards.reward_type_id', '=', 'reward_types.id')
            ->where('reward_type_name', 'EXP')->where('reward_amount', 100)->first()->id;

        // Menambahkan exp ke user yang merekomendasi
        $recommendationUser = User::findOrFail($recommendationUserId);
        $recommendationUser->increment('total_exp', 100);

        // Mengurangi kapasitas parkir
        $parkRecommendation->decrement('capacity', 1);

        // Membuat data berhasil menerima rekomendasi
        $data = ParkRecommendationAccepted::create([
            'park_recommendation_id' => $parkRecommendationId,
            'acceptant_user_id' => $acceptantUserId,
            'acceptant_reward_id' => $acceptantRewardId,
            'recommendation_reward_id' => $recommendationRewardId,
        ]);

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Menerima Rekomendasi Parkir',
        ], 200);
    }
}
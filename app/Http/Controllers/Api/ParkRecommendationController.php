<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkArea;
use App\Models\ParkRecommendation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ParkRecommendationController extends Controller
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

    // Merekomendasi parkir
    public function parkRecommendation(Request $request, ParkArea $parkArea)
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil id park area
        $parkAreaId = $parkArea->id;

        // Validasi Input
        $request->validate([
            'capacity' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string|min:10',
        ]);

        // Upload gambar
        $image = $request->file('image');
        $image->storeAs('image/park_recommendation', $image->hashName());

        // Membuat data rekomendasi
        $data = ParkRecommendation::create([
            'park_area_id' => $parkAreaId,
            'user_id' => $userId,
            'capacity' => $request->capacity,
            'image' => 'image/park_recommendation/' . $image->hashName(),
            'description' => $request->description,
        ]);

        // Menambahkan exp ke user
        $recommendationUser = User::findOrFail($userId);
        $recommendationUser->increment('total_exp', 10);

        // Update rank
        $recommendationUser->updateRank();

        // Mengembalikan response API
        return response([
            'code' => 201,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Merekomendasikan Parkir',
        ], 201);
    }
}

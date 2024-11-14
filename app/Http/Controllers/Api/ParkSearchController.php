<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkArea;
use App\Models\ParkData;
use App\Models\ParkRecommendation;
use Illuminate\Http\Request;

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

    public function parkRecommendation()
    {
        $data = ParkRecommendation::all();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Rekomendasi Parkir',
        ], 200);
    }

    public function parkRecommendationAccepted()
    {
        //
    }
}
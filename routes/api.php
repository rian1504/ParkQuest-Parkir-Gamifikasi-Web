<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\ParkRecommendationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Authentication
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    // User
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // Leaderboard
    Route::get('/topThree', [LeaderboardController::class, 'topThree']);
    Route::get('/leaderboard', [LeaderboardController::class, 'leaderboard']);
    Route::get('/userLeaderboard', [LeaderboardController::class, 'userLeaderboard']);

    // Rekomendasi Parkir
    Route::get('/parkArea', [ParkRecommendationController::class, 'parkArea']);
    Route::post('/parkRecommendation/{parkArea}', [ParkRecommendationController::class, 'parkRecommendation']);
});
<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\AvatarController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\ParkRecommendationController;
use App\Http\Controllers\Api\ParkSearchController;
use App\Http\Controllers\Api\ReferralController;
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

    // Pencarian Parkir
    Route::get('/parkAreaSearch', [ParkSearchController::class, 'parkArea']);
    Route::get('/parkData/{parkArea}', [ParkSearchController::class, 'parkData']);
    Route::get('/parkRecommendation', [ParkSearchController::class, 'parkRecommendation']);
    Route::post('/parkRecommendationAccepted/{parkRecommendation}', [ParkSearchController::class, 'parkRecommendationAccepted']);

    // Avatar
    // Shop
    Route::prefix('shop')->group(function () {
        Route::get('/basic', [AvatarController::class, 'shopBasic']);
        Route::get('/rare', [AvatarController::class, 'shopRare']);
        Route::get('/legendary', [AvatarController::class, 'shopLegendary']);
        Route::get('/detail/{avatar}', [AvatarController::class, 'shopDetail']);
        Route::post('/buyAvatar/{avatar}', [AvatarController::class, 'buyAvatar']);
    });
    // Inventory
    Route::prefix('inventory')->group(function () {
        Route::get('/basic', [AvatarController::class, 'inventoryBasic']);
        Route::get('/rare', [AvatarController::class, 'inventoryRare']);
        Route::get('/legendary', [AvatarController::class, 'inventoryLegendary']);
        Route::get('/detail/{avatar}', [AvatarController::class, 'inventoryDetail']);
        Route::post('/updateAvatar/{avatar}', [AvatarController::class, 'updateAvatar']);
    });

    // Kode Referral
    Route::get('/referral', [ReferralController::class, 'index']);
    Route::post('/referral', [ReferralController::class, 'store']);
});

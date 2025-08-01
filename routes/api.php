<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\AvatarController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\MissionController;
use App\Http\Controllers\Api\ParkRecommendationController;
use App\Http\Controllers\Api\ParkSearchController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// v1
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        // Profile
        Route::get('/profile', [AuthenticationController::class, 'profile']);
        Route::post('/profile', [AuthenticationController::class, 'editProfile']);
        Route::post('/password', [AuthenticationController::class, 'editPassword']);
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
        Route::get('/parkRecommendation/{parkArea}', [ParkSearchController::class, 'parkRecommendation']);
        Route::get('/parkRecommendationDetail/{parkRecommendation}', [ParkSearchController::class, 'parkRecommendationDetail']);
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

        // Misi
        Route::get('/mission', [MissionController::class, 'index']);
        Route::post('/dailyLogin', [MissionController::class, 'dailyLogin']);

        // Survey
        Route::get('/survey', [SurveyController::class, 'index']);
        Route::get('/survey/{survey}', [SurveyController::class, 'show']);
        Route::post('/survey/{survey}', [SurveyController::class, 'submit']);
    });
});

<?php

namespace App\Http\Controllers\Api;

use App\Models\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    // Mengambil semua data avatar basic pada shop
    public function basic()
    {
        // Mengambil semua data avatar basic
        $data = Avatar::join('rarities', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('rarity_name', 'basic')
            ->whereNotIn('avatars.id', function ($query) {
                $query->select('avatar_id')
                    ->from('user_avatars');
            })
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Avatar Basic',
        ], 200);
    }

    // Mengambil semua data avatar rare pada shop
    public function rare()
    {
        // Mengambil semua data avatar rare
        $data = Avatar::join('rarities', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('rarity_name', 'rare')
            ->whereNotIn('avatars.id', function ($query) {
                $query->select('avatar_id')
                    ->from('user_avatars');
            })
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Avatar Rare',
        ], 200);
    }

    // Mengambil semua data avatar legendary pada shop
    public function legendary()
    {
        // Mengambil semua data avatar legendary
        $data = Avatar::join('rarities', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('rarity_name', 'legendary')
            ->whereNotIn('avatars.id', function ($query) {
                $query->select('avatar_id')
                    ->from('user_avatars');
            })
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Avatar Legendary',
        ], 200);
    }

    // Mengambil detail data avatar pada shop
    public function shopDetail(Avatar $avatar)
    {
        // Mengambil id avatar
        $avatarId = $avatar->id;

        // Mengambil detail data avatar
        $data = Avatar::with('rarity')->where('id', $avatarId)->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Detail Data Avatar',
        ], 200);
    }

    // Membeli avatar
    public function buyAvatar(Avatar $avatar)
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil id avatar
        $avatarId = $avatar->id;

        // Mengambil harga avatar
        $avatarPrice = $avatar->rarity->price;

        // Mengambil jumlah coin user
        $userCoin = User::where('id', $userId)->first()->coin;

        // Cek apakah koin mencukupi
        if ($userCoin - $avatarPrice < 0) {
            // Mengembalikan response API gagal
            return response([
                'code' => 400,
                'status' => false,
                'message' => 'Gagal Membeli Avatar',
            ], 400);
        } else {
            // Mengurangi coin user
            $user = User::findOrFail($userId);
            $user->decrement('coin', $avatarPrice);

            // Membuat data user avatar
            $data = UserAvatar::create([
                'user_id' => $userId,
                'avatar_id' => $avatarId
            ]);

            // Mengembalikan response API berhasil
            return response([
                'code' => 201,
                'status' => true,
                'data' => $data,
                'message' => 'Berhasil Membeli Avatar',
            ], 201);
        }
    }
}
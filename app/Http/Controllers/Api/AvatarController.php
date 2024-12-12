<?php

namespace App\Http\Controllers\Api;

use App\Models\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rarity;
use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    // Mengambil semua data avatar basic pada shop
    public function shopBasic()
    {
        // Mengambil semua data avatar basic
        $data = Rarity::join('avatars', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('rarity_name', 'basic')
            ->whereNotIn('avatars.id', function ($query) {
                // Mengambil user id
                $userId = Auth::user()->id;

                $query->select('avatar_id')
                    ->from('user_avatars')
                    ->where('user_id', $userId);
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
    public function shopRare()
    {
        // Mengambil semua data avatar rare
        $data = Rarity::join('avatars', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('rarity_name', 'rare')
            ->whereNotIn('avatars.id', function ($query) {
                // Mengambil user id
                $userId = Auth::user()->id;

                $query->select('avatar_id')
                    ->from('user_avatars')
                    ->where('user_id', $userId);
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
    public function shopLegendary()
    {
        // Mengambil semua data avatar legendary
        $data = Rarity::join('avatars', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('rarity_name', 'legendary')
            ->whereNotIn('avatars.id', function ($query) {
                // Mengambil user id
                $userId = Auth::user()->id;

                $query->select('avatar_id')
                    ->from('user_avatars')
                    ->where('user_id', $userId);
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
        $data = Avatar::with('rarity')->findOrFail($avatarId);

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

    // Mengambil semua data avatar basic pada inventory
    public function inventoryBasic()
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil semua data avatar basic
        $data = UserAvatar::join('avatars', 'user_avatars.avatar_id', '=', 'avatars.id')
            ->join('rarities', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('user_id', $userId)
            ->where('rarity_name', 'basic')
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Avatar Basic',
        ], 200);
    }

    // Mengambil semua data avatar Rare pada inventory
    public function inventoryRare()
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil semua data avatar Rare
        $data = UserAvatar::join('avatars', 'user_avatars.avatar_id', '=', 'avatars.id')
            ->join('rarities', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('user_id', $userId)
            ->where('rarity_name', 'rare')
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Avatar Rare',
        ], 200);
    }

    // Mengambil semua data avatar Legendary pada inventory
    public function inventoryLegendary()
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil semua data avatar Legendary
        $data = UserAvatar::join('avatars', 'user_avatars.avatar_id', '=', 'avatars.id')
            ->join('rarities', 'avatars.rarity_id', '=', 'rarities.id')
            ->where('user_id', $userId)
            ->where('rarity_name', 'legendary')
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Data Avatar Legendary',
        ], 200);
    }

    // Mengambil detail data avatar pada inventory
    public function inventoryDetail(Avatar $avatar)
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil id avatar
        $avatarId = $avatar->id;

        // Mengambil detail data avatar
        $data = UserAvatar::with('avatar')
            ->where('avatar_id', $avatarId)
            ->where('user_id', $userId)
            ->get();

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil Mengambil Detail Data Avatar',
        ], 200);
    }

    // Mengubah Avatar
    public function updateAvatar(Avatar $avatar)
    {
        // Mengambil id user
        $userId = Auth::user()->id;

        // Mengambil id avatar
        $avatarId = $avatar->id;

        // Mengambil image avatar
        $avatarImage = $avatar->avatar_image;

        // Update status equipped gambar lama
        $userAvatar = UserAvatar::where('user_id', $userId)
            ->where('is_equipped', true)
            ->update(['is_equipped' => false]);

        // Update status equipped gambar baru
        UserAvatar::where('user_id', $userId)
            ->where('avatar_id', $avatarId)
            ->update(['is_equipped' => true]);

        // Update User avatar
        $user = User::findOrFail($userId);
        $user->update([
            'avatar' => $avatarImage
        ]);

        // Mengembalikan response API
        return response([
            'code' => 200,
            'status' => true,
            'data' => $user,
            'message' => 'Berhasil Memperbarui Data Avatar',
        ], 200);
    }
}
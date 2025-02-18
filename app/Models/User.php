<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'username',
    //     'email',
    //     'password',
    // ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $panel_id = $panel->getId();
        if ($panel_id === 'admin') {
            return $this->is_admin == 1;
        } else {
            return false;
        }
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function survey_response(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function park_recommendation_accepted(): HasMany
    {
        return $this->hasMany(ParkRecommendationAccepted::class);
    }

    public function park_recommendation(): HasMany
    {
        return $this->hasMany(ParkRecommendation::class);
    }

    public function eksternal(): HasOne
    {
        return $this->hasOne(Eksternal::class);
    }

    public function referral_usage(): HasMany
    {
        return $this->hasMany(ReferralUsage::class);
    }

    public function user_mission(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }

    public function leaderboard(): HasOne
    {
        return $this->hasOne(Leaderboard::class);
    }

    public function user_avatar(): HasMany
    {
        return $this->hasMany(UserAvatar::class);
    }

    public function updateRank()
    {
        // Ambil rank yang sesuai berdasarkan total_exp pengguna
        $newRank = Rank::where('exp_required', '<=', $this->total_exp)
            ->orderBy('exp_required', 'desc')
            ->first();

        // Jika rank ditemukan dan berbeda dengan rank saat ini, update rank_id
        if ($newRank && $newRank->id !== $this->rank_id) {
            $this->rank_id = $newRank->id;
            $this->save(); // Event `updated` akan otomatis dipicu
        }
    }

    protected static function booted()
    {
        static::updated(function ($user) {
            // Jika rank_id di tabel users berubah, update rank_id di tabel leaderboard
            if ($user->isDirty('rank_id')) {
                $user->leaderboard()->update(['rank_id' => $user->rank_id]);

                // Ambil misi weekly berdasarkan rank_id yang baru
                $weeklyMission = Mission::whereHas('mission_category', function ($query) {
                    $query->where('mission_category_name', 'Weekly');
                })
                    ->where('rank_id', $user->rank_id)
                    ->first();

                if ($weeklyMission) {
                    // Update UserMission yang berkategori weekly untuk user ini
                    UserMission::where('user_id', $user->id)
                        ->whereHas('mission.mission_category', function ($query) {
                            $query->where('mission_category_name', 'Weekly');
                        })
                        ->update([
                            'mission_id' => $weeklyMission->id,
                            'streak' => 0,
                            'status' => 'in progress'
                        ]);
                }
            }
        });
    }
}
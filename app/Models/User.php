<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function internal(): HasMany
    {
        return $this->hasMany(Internal::class);
    }

    public function eksternal(): HasMany
    {
        return $this->hasMany(Eksternal::class);
    }

    public function referral_usage(): HasMany
    {
        return $this->hasMany(ReferralUsage::class);
    }

    public function user_mission(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }

    public function leaderboard(): HasMany
    {
        return $this->hasMany(Leaderboard::class);
    }

    public function user_avatar(): HasMany
    {
        return $this->hasMany(UserAvatar::class);
    }
}
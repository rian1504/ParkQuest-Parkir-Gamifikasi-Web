<?php

namespace App\Providers;

use App\Models\Avatar;
use App\Models\ParkArea;
use App\Observers\AvatarObserver;
use App\Observers\ParkAreaObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ParkArea::observe(ParkAreaObserver::class);
        Avatar::observe(AvatarObserver::class);
    }
}

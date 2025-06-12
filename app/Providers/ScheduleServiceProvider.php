<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Schedule $schedule): void
    {
        // Jadwalkan reset misi mingguan
        // $schedule->command('missions:reset-weekly')->weeklyOn(1, '00:00'); // Setiap Senin pukul 00:00
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Mission;
use App\Models\UserMission;
use Illuminate\Console\Command;

class ResetWeeklyMissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'missions:reset-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset streak missions setiap minggu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua misi daily
        $dailyLoginMissionId = Mission::whereHas('mission_category', function ($query) {
            $query->where('mission_category_name', 'Daily');
        })->first()->id;

        // Ambil minggu sekarang
        $currentWeek = now()->weekOfYear;

        // Reset semua misi yang tidak sesuai minggu sekarang
        UserMission::where('week_number', '<', $currentWeek)
            ->update([
                'streak' => 0,
                'status' => 'in progress',
                'week_number' => $currentWeek, // Update ke minggu baru
            ]);

        // Update misi yang memiliki mission_id antara 3 dan 5
        UserMission::whereBetween('mission_id', [3, 5])
            ->update([
                'mission_id' => $dailyLoginMissionId,
            ]);

        $this->info('Semua misi mingguan telah direset.');
    }
}

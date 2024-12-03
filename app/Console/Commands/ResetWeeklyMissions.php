<?php

namespace App\Console\Commands;

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
        // Ambil minggu sekarang
        $currentWeek = now()->weekOfYear;

        // Reset semua misi yang tidak sesuai minggu sekarang
        UserMission::where('week_number', '<', $currentWeek)
            ->update([
                'streak' => 0,
                'status' => 'in progress',
                'week_number' => $currentWeek, // Update ke minggu baru
            ]);

        $this->info('Semua misi mingguan telah direset.');
    }
}

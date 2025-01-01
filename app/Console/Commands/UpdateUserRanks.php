<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserRanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user-ranks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update rank user ketika exp bertambah';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->updateRank();
        }

        $this->info('Rank user telah diupdate.');
    }
}

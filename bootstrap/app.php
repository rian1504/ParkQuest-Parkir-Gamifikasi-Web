<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('missions:reset-weekly')
            ->weeklyOn(1, '00:00')
            ->timezone('Asia/Jakarta')
            ->onFailure(function () {
                Log::error('Failed to run weekly reset missions');
            });
        $schedule->command('update:user-ranks')
            ->everyMinute()
            ->timezone('Asia/Jakarta')
            ->onFailure(function () {
                Log::error('Failed to run update rank users');
            });
    })
    ->create();

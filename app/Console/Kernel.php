<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands=[
        \App\Console\Commands\Test::class,
        \App\Console\Commands\DailyRateUpdates::class,
        \App\Console\Commands\new1::class,
        

    ];
    protected function schedule(Schedule $schedule): void
    {
        //  $schedule->command('test:add')->everyMinute();
         $schedule->command('hit:dailyy')->dailyAt('10:00');
         $schedule->command('new1:run')->dailyAt('22:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ZipController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       'App\Console\Commands\TestCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
      {
            $schedule->command('command:task_date')->everyFiveMinutes();

            //$schedule->command('command:generarZip')
                     //->monthly()
                     //->at('02:00');
            $schedule->command('command:generarZip')
                     ->everyFiveMinutes();
            $schedule->command('command:VencimientosDocumentaciones')->dailyAt(config('cron.time_cron_documentaciones'));
            $schedule->command('command:DemoraCargaDosimetria')->dailyAt(config('cron.time_cron_dosimetria'));
            
        }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

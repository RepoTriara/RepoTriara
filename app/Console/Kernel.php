<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define las tareas programadas.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Registrar el comando files:delete-expired
        $schedule->command('files:delete-expired')->dailyAt('00:00');
        \Log::info('Scheduler ejecutado a las: ' . now());
    }

    /**
     * Registra los comandos para la aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

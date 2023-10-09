<?php

namespace App\Console;

use App\Models\Reservation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        'App\Console\Commands\SetPassedCommand'
    ];

    protected function schedule(Schedule $schedule): void
    {
        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            $end_time = Carbon::parse("$reservation->day $reservation->end");

            if(!$reservation->passed) {
                $schedule->command('set:passed')->when($end_time->isPast())->withoutOverlapping();
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
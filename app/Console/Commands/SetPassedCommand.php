<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SetPassedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:passed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a Reservation to Passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            $end_time = Carbon::parse("$reservation->day $reservation->end");

            if($end_time->isPast() && !$reservation->passed) {
                $reservation->update(['passed' => true]);
            }
        }
    }
}

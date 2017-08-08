<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Eloquents\RenderBooking;
use App\Eloquents\OrderBooking;
use Carbon\Carbon;

class ChangeInlateBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:change-inlate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status Inlate for Booking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start change status InLate order booking!');

        $currentDay = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');
        $currentRenders = RenderBooking::with('OrderBooking')
            ->where('day', $currentDay)
            ->where('time_start', '<=', $currentTime)
            ->get();

        foreach ($currentRenders as $render) {
            foreach ($render->OrderBooking as $booking) {
                if ($booking->status == OrderBooking::STATUS_PENDING) {
                    $booking->status = OrderBooking::STATUS_INLATE;
                    $booking->save();
                }
            }
        }

        return $this->info('The booking changed status InLate successfully!');;
    }
}

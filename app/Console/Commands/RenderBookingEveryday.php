<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Eloquents\RenderBooking;
use App\Eloquents\Department;
use Carbon\Carbon;

class RenderBookingEveryday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'render:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Render Booking Every day!';

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
        // Disable Booking yesterday
        $currentDay = Carbon::today()->addDay(-1)->format('Y-m-d');
        $oldRenders = RenderBooking::where('day', $currentDay)->get();
        foreach ($oldRenders as $oldRender) {
            $oldRender->status = RenderBooking::STATUS_DISABLE;
            $oldRender->save();
        }

        // Add New Booking
        $departments = Department::all();

        $renderDay = Carbon::today()->addDay(config('default.render_day') - 1)->format('Y-m-d');
        $workOpen = explode(':', config('default.work_open'));
        $workClose = explode(':', config('default.work_close'));

        $workOpenHour = $workOpen[0];
        $workOpenMinute = $workOpen[1];
        $workCloseHour = $workClose[0];
        $workCloseMinute = $workClose[1];
        $timeSlot = config('default.time_slot');

        for (;;) {
            if ($workOpenHour * 60 + $workOpenMinute + $timeSlot > $workCloseHour * 60 + $workCloseMinute) {
                break;
            }

            foreach ($departments as $department) {
                $data = [
                    'day' => $renderDay,
                    'time_start' => $workOpenHour . ':' . $workOpenMinute,
                    'department_id' => $department->id,
                    'total_slot' => 1,
                    'status' => RenderBooking::STATUS_ENABLE,
                ];

                RenderBooking::create($data);
            }
            $workOpenMinute += $timeSlot;

            if ($workOpenMinute >= 60) {
                $workOpenHour++;
                $workOpenMinute -=60;
            }

        }
    }
}

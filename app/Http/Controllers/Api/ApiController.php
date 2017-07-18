<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\RenderBookingRepository;
use App\Contracts\Repositories\DepartmentRepository;
use App\Contracts\Repositories\UserRepository;
use Carbon\Carbon;
use App\Helpers\Helper;
use Response;

class ApiController extends Controller
{
    protected $renderBooking;
    protected $department;
    protected $user;

    public function __construct(
        RenderBookingRepository $renderBooking,
        DepartmentRepository $department,
        UserRepository $user
    ) {
        $this->renderBooking = $renderBooking;
        $this->department = $department;
        $this->user = $user;
    }

    public function firstRenderBooking()
    {
        $issetData = $this->renderBooking->model()->first();
        if ($issetData) {
            $message[] = __('Booking was rendered!');
            return Response::json(Helper::apiFormat(true, [], $message, 403), 403);
        }

        $departments = $this->department->getAllData([], ['id']);

        for ($i=0; $i < config('default.render_day') ; $i++) { 

            $currentDay = Carbon::today()->addDay($i)->format('Y-m-d');
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
                        'day' => $currentDay,
                        'time_start' => $workOpenHour . ':' . $workOpenMinute,
                        'department_id' => $department->id,
                        'total_slot' => 1,
                        'status' => \App\Eloquents\RenderBooking::STATUS_ENABLE,
                    ];

                    $this->renderBooking->create($data);
                }
                $workOpenMinute += $timeSlot;

                if ($workOpenMinute >= 60) {
                    $workOpenHour++;
                    $workOpenMinute -=60;
                }

            }
        }

        $message[] = __('Render booking successful!');

        return Response::json(Helper::apiFormat(false, [], $message, 200), 200);

    }
}

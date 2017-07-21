<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\RenderBookingRepository;
use App\Contracts\Repositories\DepartmentDayoffRepository;
use App\Contracts\Repositories\DepartmentRepository;
use App\Contracts\Repositories\UserRepository;
use App\Eloquents\DepartmentDayoff;
use App\Eloquents\RenderBooking;
use App\Helpers\Helper;
use Carbon\Carbon;
use Response;

class RenderBookingController extends Controller
{
    protected $renderBooking;
    protected $dayoff;
    protected $department;
    protected $user;

    public function __construct(
        RenderBookingRepository $renderBooking,
        DepartmentDayoffRepository $dayoff,
        DepartmentRepository $department,
        UserRepository $user
    ) {
        $this->renderBooking = $renderBooking;
        $this->dayoff = $dayoff;
        $this->department = $department;
        $this->user = $user;
    }

    public function getRenderBooking(Request $request)
    {
        $response = Helper::apiFormat();

        $department_id = $request->department_id;
        $department = $this->department->find($department_id);
        if (!$department) {
            $response['status'] = 403;
            $response['message'][] = __('This Department does not exists');

            return Response::json($response, $response['status']);
        }

        $statusOption = RenderBooking::getOptionStatus();

        $stylist_id = $request->stylist_id;
        $stylistDepartment = $this->user->getStylistByDepartmentId($department_id);
        $totalStylist = $stylistDepartment->count();

        $dayoffCollection = $this->dayoff->getDayoffByDepartment($department_id);

        $dataRespone = [];
        for ($i=0; $i < config('default.render_day') ; $i++) { 
            $currentDay = Carbon::today()->addDay($i)->format('Y-m-d');

            $dayoff = $dayoffCollection->where('day', $currentDay)->first();
            if ($dayoff) {
                $dataRespone[$currentDay] = [
                    'status' => DepartmentDayoff::OFF_WORK,
                    'title' => $dayoff->title,
                    'renders' => [],
                ];
                continue;
            }

            $dataRenders = ['status' => DepartmentDayoff::ON_WORK, 'title' => ''];
            $renderCollection = $this->renderBooking
                ->getRenderDepartment($department_id, $currentDay, ['getOrderBooking']);

            $renders = [];
            foreach ($renderCollection as $render) {
                $render->status = RenderBooking::STATUS_ENABLE;
                $render->statusLabel = $statusOption[RenderBooking::STATUS_ENABLE];
                $render->total_slot = $totalStylist - $render->getOrderBooking->count();

                if ($stylist_id) {
                    $stylistOrder = $render->getOrderBooking->where('stylist_id', $stylist_id)->first();
                    $render->total_slot = 1;
                    if ($stylistOrder) {
                        $render->status = RenderBooking::STATUS_DISABLE;
                        $render->statusLabel = $statusOption[RenderBooking::STATUS_DISABLE];
                        $render->total_slot = 0;
                    } else {
                        // xu ly ngay stylist nghi, version sau
                    }
                } elseif ($render->getOrderBooking->count() >= $totalStylist) {
                    $render->status = RenderBooking::STATUS_DISABLE;
                    $render->statusLabel = $statusOption[RenderBooking::STATUS_DISABLE];
                    $render->total_slot = 0;
                }

                $renders[] = $render;
            }
            $dataRenders['renders'] = $renders;

            $dataRespone[$currentDay] = $dataRenders;
        }

        $response['data'] = $dataRespone;

        return Response::json($response, $response['status']);
    }
}

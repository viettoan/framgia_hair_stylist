<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\OrderBookingRepository;
use App\Contracts\Repositories\RenderBookingRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\DepartmentRepository;
use App\Helpers\Helper;
use App\Eloquents\OrderBooking;
use Validator;
use Auth;
use Response;
use Carbon\Carbon;

class OrderBookingController extends Controller
{
    protected $OrderBooking, $RenderBooking, $user, $department;

    public function __construct( 
        OrderBookingRepository $OrderBooking, 
        RenderBookingRepository $RenderBooking,
        UserRepository $user,
        DepartmentRepository $department
    ) {
        $this->OrderBooking = $OrderBooking;
        $this->RenderBooking = $RenderBooking;
        $this->user = $user;
        $this->department = $department;
    }

    public function getBookingbyId($bookingId)
    {
        $response = Helper::apiFormat();

        $booking = $this->OrderBooking->getBookingByBookingId($bookingId);

        if (empty($booking))
        {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __('404 not found');

            return Response::json($response);
        }
        
        if ($booking->count() == 0)
        {
            $response['message'][] = __("There's no booking currently");
        }

        $response['data'] = $booking;
        
        return Response::json($response);
    }

    public function userBooking(Request $request)
    {

        $response = Helper::apiFormat();

        $rule = [
            'render_booking_id' => 'required',
            'phone' => 'required|numeric|min:6',
            'name' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                $response['message'][$key] = $validator->messages()->first($key);
            }

            return Response::json($response, 403);
        }

        $stylist_id = $request->stylist_chosen;
        $renderBooking = $this->RenderBooking->find($request->render_booking_id, ['OrderBooking']);
        if (!$stylist_id) {
            $orderCollection = $renderBooking->OrderBooking;
            $stylists = $this->user->getStylistByDepartmentId($renderBooking->department_id);
            
            foreach ($stylists as $stylist) {
                if(!$orderCollection->where('stylist_id', $stylist->id)->first()) {
                    $stylist_id = $stylist->id;
                    break;
                }
            }
        }
        
        $user = Auth::guard('api')->user();
        $user_id = null;
        if ($user) {
            $user_id = $user->id;
        }

        $bookingChecked = $this->OrderBooking->checkLastBookingByPhone($request->phone);

        if($bookingChecked) {
            $timeUserChosen = $this->RenderBooking->find($bookingChecked->render_booking_id);

            $difference_time = strtotime($timeUserChosen->day . ' ' . $timeUserChosen->time_start)- time();

            if($difference_time > 0) {
                $bookingChecked->fill($request->all());
                $bookingChecked->stylist_id = $stylist_id;
                $bookingChecked->user_id = $user_id;
                $bookingChecked->save();

                $dataResponse = $this->OrderBooking->find($bookingChecked->id);

            } else {
                $data = [
                    'render_booking_id' => $request->render_booking_id,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'stylist_id' => $stylist_id,
                    'user_id' => $user_id,
                ];
                $order = $this->OrderBooking->create($data);

                $dataResponse = $this->OrderBooking->find($order->id);
            }
            $dataResponse->render_booking = $timeUserChosen;

        } else {
            $order = $this->OrderBooking->create([
                'render_booking_id' => $request->render_booking_id,
                'phone' => $request->phone,
                'name' => $request->name,
                'stylist_id' => $stylist_id,
                'user_id' => $user_id,
            ]);

            $dataResponse = $this->OrderBooking->find($order->id);
            $dataResponse->render_booking = $this->RenderBooking->find($request->render_booking_id);
        }
        $dataResponse->department = $this->department->find($renderBooking->department_id);
        $dataResponse->stylist = $stylist_name = $this->user->find($stylist_id);

        $response['data'] = $dataResponse;

        return Response::json($response, $response['status']);
    }

    public function getBookingFilterByDay(Request $request)
    {
        $response = Helper::apiFormat();

        $today = Carbon::today();

        $dayStart =date('Y-m-d h:i:s', $request->day_start);
        $dayEnd = date('Y-m-d h:i:s', $request->day_end);
        
        $rule = [
            'day_start' => 'required|integer',
            'day_end' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                $response['message'][$key] = $validator->messages()->first($key);
            }

            return Response::json($response, 403);
        }

        if($dayStart && $dayEnd)
        {
            if(  $request->day_start >  $request->day_end )
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = 'Day end must be after day start!';

                return Response::json($response);
            }
            $perPage = $request->per_page ?: config('model.booking.default_filter_limit');

            $data = $this->OrderBooking->filterBookingByDay($dayStart, $dayEnd, $perPage, 'getBookingRender');

            if($data->count() == 0)
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = "There's no booking on these day!";

                return Response::json($response);
            }
        }

        $response['data'] = $data;

        return Response::json($response);

    }

}

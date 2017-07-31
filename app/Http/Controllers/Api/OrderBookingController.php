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

        $currentDate = Carbon::today(); //2017-07-28 00:00:00

        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');

        // if no choice filter, default is none, display all
        if( $request->filter_choice == 0)
        {
            $response['data'] = $this->OrderBooking->getAllBooking($perPage, 'getBookingRender');

            return Response::json($response);
        }
        // if filter by day
        if($request->filter_choice == 1)
        {   
            // default is get all booking today
            if(!$request->start_date && !$request->end_date)
            {
                 $tomorrow = Carbon::tomorrow(); // 2017-07-29 00:00:00

                 $response['data'] = $this->OrderBooking->filterBookingbyDate($currentDate, $tomorrow, $perPage, 'getBookingRender');

                 return Response::json($response);
            }

            $rule = [
                'start_date' => 'required|integer',
                'end_date' => 'required|integer',
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

            $startDate =date('Y-m-d h:i:s', $request->start_date);
            $endDate = date('Y-m-d h:i:s', $request->end_date);

            if(  $request->start_date >  $request->end_date )
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = __('Day end must be after day start!');

                return Response::json($response);
            }


            $data = $this->OrderBooking->filterBookingbyDate($startDate, $endDate, $perPage, 'getBookingRender');

            if($data->count() == 0)
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = __("There's no booking on these day!");

                return Response::json($response);
            }

            $response['data'] = $data;

            return Response::json($response);
        }
        // if filter by month       
        if($request->filter_choice == 2)
        {
            // default is get all booking current month
            if(!$request->month_input && !$request->year_input)
            {

                 $response['data'] = $this->OrderBooking->filterBookingByMonth($currentDate->month, $currentDate->year, $perPage, 'getBookingRender');

                 return Response::json($response);
            }

            $rule = [
                'month_input' => 'required|integer|min:1|max:12',
                'year_input' => 'required|integer',
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

            $data = $this->OrderBooking->filterBookingByMonth($request->month_input, $request->year_input, $perPage, 'getBookingRender');

            if($data->count() == 0)
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = __("There's no booking on these day!");

                return Response::json($response);
            }

            $response['data'] = $data;

            return Response::json($response);
        }

        if($request->filter_choice == 3)
        {
            //set date default to get the first monday in month
            $startOfMonth =strtotime($request->year_input.'-'.$request->month_input.'-01');

            $rule = [
                'week_input' => 'required|integer|min:1|max:5',
                'month_input' => 'required|integer|min:1|max:12',
                'year_input' => 'required|integer',
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

            switch ($request->week_input) {
                case "1":
                    $startDate = date('Y-m-d H:i:s', $startOfMonth);
                    break;
                case "2":
                    $startDate = date('Y-m-d H:i:s', strtotime('+1 week', $startOfMonth));
                    break;
                case "3":
                    $startDate = date('Y-m-d H:i:s', strtotime('+2 week', $startOfMonth));
                    break;
                case "4":
                    $startDate = date('Y-m-d H:i:s', strtotime('+3 week', $startOfMonth));
                    break;
                case "5":
                    $startDate = date('Y-m-d H:i:s', strtotime('+4 week', $startOfMonth));
                    break;
            }

            $endDate = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($startDate)));

            $data = $this->OrderBooking->filterBookingbyDate($startDate, $endDate, $perPage, 'getBookingRender');

            if($data->count() == 0)
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = __("There's no booking on these day!");

                return Response::json($response);
            }

            $response['data'] = $data;

            return Response::json($response);
        }
        // filter by status
        if($request->filter_choice == 4)
        {
            $rule = [
            'status' => 'required|integer',
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

            $data = $this->OrderBooking->filterBookingByStatus($request->status, $perPage, 'getBookingRender');

            if($data->count() == 0)
            {
                $response['status'] = 403;
                $response['error'] = true;
                $response['message'][] = __("There's no booking with this status!");

                return Response::json($response);
            }

            $response['data'] = $data;

            return Response::json($response);
        }

        
    }

    public function getBookingbyUserId($user_id)
    {
        $response = Helper::apiFormat();

        $booking = $this->OrderBooking->getBookingByCustomerId($user_id);

        if(!$booking) {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __('404 not found');

            return Response::json($response);

        }
        
        $response['data'] = $booking;

        return Response::json($response);
    }
}
//week test value:
//2017-07-25     1500915600
//2017-07-19     1500397200
//2017-07-29     1501261200
//2017-06-12     1497200400

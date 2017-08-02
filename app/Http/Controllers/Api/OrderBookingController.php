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
    protected $orderBooking, $renderBooking, $user, $department;

    public function __construct( 
        OrderBookingRepository $orderBooking, 
        RenderBookingRepository $renderBooking,
        UserRepository $user,
        DepartmentRepository $department
    ) 
    {
        $this->orderBooking = $orderBooking;
        $this->renderBooking = $renderBooking;
        $this->user = $user;
        $this->department = $department;
    }

    public function getBookingbyId($bookingId)
    {
        $response = Helper::apiFormat();

        $booking = $this->orderBooking->getBookingByBookingId($bookingId, 'getBookingRender');

        if (!$booking)
        {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __('404 not found');

            return Response::json($response);
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
        $renderBooking = $this->renderBooking->find($request->render_booking_id, ['OrderBooking']);
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

        $bookingChecked = $this->orderBooking->checkLastBookingByPhone($request->phone);

        if($bookingChecked) {
            $timeUserChosen = $this->renderBooking->find($bookingChecked->render_booking_id);

            $difference_time = strtotime($timeUserChosen->day . ' ' . $timeUserChosen->time_start)- time();

            if($difference_time > 0) {
                $bookingChecked->fill($request->all());
                $bookingChecked->stylist_id = $stylist_id;
                $bookingChecked->user_id = $user_id;
                $bookingChecked->save();

                $dataResponse = $this->orderBooking->find($bookingChecked->id);

            } else {
                $data = [
                    'render_booking_id' => $request->render_booking_id,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'stylist_id' => $stylist_id,
                    'user_id' => $user_id,
                ];
                $order = $this->orderBooking->create($data);

                $dataResponse = $this->orderBooking->find($order->id);
            }
            $dataResponse->render_booking = $timeUserChosen;

        } else {
            $order = $this->orderBooking->create([
                'render_booking_id' => $request->render_booking_id,
                'phone' => $request->phone,
                'name' => $request->name,
                'stylist_id' => $stylist_id,
                'user_id' => $user_id,
            ]);

            $dataResponse = $this->orderBooking->find($order->id);
            $dataResponse->render_booking = $this->renderBooking->find($request->render_booking_id);
        }
        $dataResponse->department = $this->department->find($renderBooking->department_id);
        $dataResponse->stylist = $stylist_name = $this->user->find($stylist_id);

        $response['data'] = $dataResponse;

        return Response::json($response, $response['status']);
    }

    public function filterBooking(Request $request)
    {
        $response = Helper::apiFormat();

        $startDate = Carbon::today()->format('Y-m-d H:i:s');
        $endDate = Carbon::today()->endOfDay();
        $filter_date = $request->date;
        $filter_type = $request->type;//today - week - month //default today

        $date_start = Carbon::createFromTimestamp($request->start_date);
        $date_end = Carbon::createFromTimestamp($request->end_date);
        switch ($filter_type) {
            case 'day':
                $startDate = $date_start->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $date_start->endOfDay();
                break;
            case 'space':
                $startDate = $date_start->startOfWeek()->format('Y-m-d H:i:s');
                $endDate = $date_end->endOfWeek()->endOfDay();
                break;
        }

        $filter_status = $request->status; //cancel - finished - pending
        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');
        $page = (int) $request->page ?: 1;

        $with = [];
        $select = [
            'id',
            'render_booking_id',
            'phone',
            'name',
            'stylist_id',
            'created_at',
            'updated_at',
            'status',
        ];

        $currentDate = Carbon::now()->timestamp(strtotime($startDate))->addDay($perPage*($page-1));
        $responseData = [];
        for ($i = $perPage * ($page - 1); $i < $perPage * $page; $i++) {
            if ($currentDate->gt($endDate)) {
                break;
            }
            $start = $currentDate->format('Y-m-d') . ' 00:00:00';
            $end = $currentDate->format('Y-m-d') . ' 23:59:59';
            $orderBookings = $this->orderBooking
                ->filterBookingbyDate($start, $end, $filter_status, $with, $select);
            $data['date_book'] = $currentDate->format('Y-m-d');

            $dataBooks = [];
            foreach ($orderBookings as $orderBooking) {
                $renderBooking = $this->renderBooking->find($orderBooking->render_booking_id);
                $orderBooking->time_start = $renderBooking->time_start;
                $orderBooking->department = $this->department
                    ->find($renderBooking->department_id, [], ['name', 'address']);
                $orderBooking->stylist = $this->user
                    ->find($orderBooking->stylist_id, ['name', 'email', 'phone']);

                $dataBooks[] = $orderBooking;
            }

            $data['list_book'] = $dataBooks;
            $responseData[] = $data;
            $currentDate->addDay(1);
        }
        $response['data'] = $responseData;

        return Response::json($response, $response['status']);
    }


    public function filterByDate(Request $request)
    {

        $response = Helper::apiFormat();

        $select =['*'];// ['render_booking_id', 'name', 'status', 'stylist_id'];
        $with = ['getBookingRender', 'getStylist'];

        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');
        // if no choice filter, default is none, display all
            // default is get all booking today

        $startDate =date('Y-m-d', $request->start_date) . ' 00:00:00';
        $endDate = date('Y-m-d', $request->end_date) . ' 23:59:59';

        if (!$request->start_date) {
            $startDate = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        }

        if (!$request->end_date) {
            $endDate = Carbon::now()->format('Y-m-d') . ' 23:59:59';
        }

        $status = $request->status;
        $data = $this->orderBooking
        ->filterBookingbyDate($startDate, $endDate, $perPage, $status, $with, $select);
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

    public function filterByMonth(Request $request)
    {
        $response = Helper::apiFormat();
        $currentDate = Carbon::now();

        $select = ['render_booking_id', 'name', 'status', 'stylist_id'];
        $with = ['getBookingRender', 'getStylist'];

        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');
        // default is get all booking current month
        $month = $request->month_input;
        $year = $request->year_input;

        if (!$request->month_input) {
            $month = $currentDate->month;
        }

        if (!$request->year_input) {
            $year = $currentDate->year;
        }
        $status = $request->status;
        $data = $this->orderBooking
        ->filterBookingByMonth($month, $year, $perPage, $status, $with, $select);
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

    public function filterByWeek(Request $request)
    {
        $response = Helper::apiFormat();

        $currentDate = Carbon::today(); //2017-07-31 00:00:00

        if($request->status)
        {
            $status = $request->status;
        }
        $select = ['render_booking_id', 'name', 'status', 'stylist_id'];
        $with = ['getBookingRender', 'getStylist'];

        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');
        // default is get all booking current month
        $rule = [
            'day_of_week' => 'integer',
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
        if(!$request->day_of_week)
        {
            $startDate = Carbon::now()->startOfWeek();
        }
        else
        {
            $date = Carbon::createFromTimestamp($request->day_of_week);  
            // To get the first week of the day we can do this
            $startDate = $date->startOfWeek(); 
        }
        $endDate = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($startDate)));

        $status = $request->status;
        $data = $this->orderBooking
        ->filterBookingbyDate($startDate, $endDate, $perPage, $status, $with, $select);

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

    public function filterByStatus(Request $request)
    {
        $response = Helper::apiFormat();
        
        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');

        $data = $this->orderBooking->filterBookingByStatus($request->status, $perPage, 'getBookingRender');

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

    public function getBookingFilterByDay(Request $request)
    {
        $response = Helper::apiFormat();

        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');

        // if no choice filter, default is none, display all
        if( !$request->filter_choice)
        {
            $response['data'] = $this->orderBooking->getAllBooking($perPage, 'getBookingRender');

            return Response::json($response);
        }
        // // if filter by day
        if($request->filter_choice == 'day')
        {   
            return $this->filterByDate($request);
        }
        // if filter by month       
        if($request->filter_choice == 'month')
        {
            return $this->filterByMonth($request);
        }

        if($request->filter_choice == 'week')
        {
            return $this->filterByWeek($request);
        }
    }
    
    public function getBookingbyUserId($user_id)
    {
        $response = Helper::apiFormat();

        $booking = $this->orderBooking->getBookingByCustomerId($user_id);

        if(!$booking) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = __('404 not found');

            return Response::json($response);
        }
        
        $response['data'] = $booking;

        return Response::json($response);
    }

    public function getBookingbyPhoneLastest(Request $request)
    {
        $response = Helper::apiFormat();

        $booking = $this->orderBooking->checkLastBookingByPhone($request->phone);

        if($booking) {
            $booking->render_booking = $this->renderBooking->find($booking->render_booking_id);
            $booking->department = $this->department->find($booking->render_booking->department_id);
            $booking->stylist = $this->user->find($booking->stylist_id);

            $response['data'] = $booking;
        }

        return Response::json($response);
    }
}

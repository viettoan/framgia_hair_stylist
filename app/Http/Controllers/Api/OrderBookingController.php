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
use App\Eloquents\User;
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

    public function userBooking(Request $request)
    {
        $response = Helper::apiFormat();

        $rule = [
            'render_booking_id' => 'required',
            'phone' => 'required|numeric|digits_between:6,25',
            'name' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, 403);
        }

        $stylist_id = $request->stylist_chosen;
        $renderBooking = $this->renderBooking->find($request->render_booking_id, ['OrderBooking']);

        // Tim stylist ranh nhat
        if (!$stylist_id) {
            $orderCollection = $renderBooking->OrderBooking;

            $allRenderday = $this->renderBooking->getRenderByDate($renderBooking->day, ['OrderBooking']);

            $stylists = $this->user->getStylistByDepartmentId($renderBooking->department_id);
            $listStylist = [];
            foreach ($stylists as $stylist) {
                $listStylist[$stylist->id] = 0;
            }

            foreach ($allRenderday as $renderday) {
                foreach ($renderday->OrderBooking as $bookingDay) {
                    if (isset($listStylist[$bookingDay->stylist_id])) {
                        $listStylist[$bookingDay->stylist_id] += 1;
                    }
                }
            }

            krsort($listStylist);
            foreach ($listStylist as $key => $stylist) {
                if(!$orderCollection->where('stylist_id', $key)->first()) {
                    $stylist_id = $key;
                    break;
                }
            }
        }

        if (!$stylist_id) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = __('You can not book because no stylist in your time book!');

            return Response::json($response, $response['status']);
        }
        // End Tim stylist ranh nhat
    
        $user = Auth::guard('api')->user();
        $user_id = null;
        if ($user) {
            $user_id = $user->id;
        }

        $bookingChecked = $this->orderBooking->checkLastBookingByPhone($request->phone);

        if ($bookingChecked) {
            $timeUserChosen = $this->renderBooking->find($bookingChecked->render_booking_id);

            $timeSelect = strtotime($timeUserChosen->day . ' ' . $timeUserChosen->time_start);
            $timeSelected = Carbon::createFromTimestamp($timeSelect);

            if ($timeSelected->gt(Carbon::now())) { 
                // Da booking va chua het han, thay doi booking
                $bookingChecked->fill($request->all());
                $bookingChecked->stylist_id = $stylist_id;
                $bookingChecked->user_id = $user_id;
                $bookingChecked->save();

                $dataResponse = $this->orderBooking->find($bookingChecked->id);
                $response['message'][] = __('You have changed your booking to new booking!');

            } else {
                // Tao moi booking
                $data = [
                    'render_booking_id' => $request->render_booking_id,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'stylist_id' => $stylist_id,
                    'user_id' => $user_id,
                ];
                $order = $this->orderBooking->create($data);
                $dataResponse = $this->orderBooking->find($order->id);
                $response['message'][] = __('You have successfully booked!');
            }
            $dataResponse->render_booking = $this->renderBooking->find($request->render_booking_id);

        } else {
            // Tao moi booking
            $order = $this->orderBooking->create([
                'render_booking_id' => $request->render_booking_id,
                'phone' => $request->phone,
                'name' => $request->name,
                'stylist_id' => $stylist_id,
                'user_id' => $user_id,
            ]);
            $dataResponse = $this->orderBooking->find($order->id);
            $dataResponse->render_booking = $this->renderBooking->find($request->render_booking_id);
            $response['message'][] = __('You have successfully booked!');
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
        $filter_department = $request->department_id;

        $date_start = Carbon::createFromTimestamp($request->start_date);
        $date_end = Carbon::createFromTimestamp($request->end_date);
        switch ($filter_type) {
            case 'day':
                $startDate = $date_start->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $date_start->endOfDay();
                break;
            case 'space':
                $startDate = $date_start->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $date_end->endOfDay();
                break;
        }

        $filter_status = $request->status; //cancel - finished - pending

        $currentDate = Carbon::now()->timestamp(strtotime($startDate));
        $responseData = [];
        for (;$currentDate->lte($endDate);) {

            $date_filter = $currentDate->format('Y-m-d');

            $renderBookings = $this->renderBooking
                ->getRenderByDate($date_filter, $filter_department, ['OrderBooking', 'Department']);

            $data['date_book'] = $currentDate->format('d-m-Y');
            $dataBooks = [];
            foreach ($renderBookings as $renderBooking) {
                $department = [
                    'name' => $renderBooking->Department->name,
                    'address' => $renderBooking->Department->address,
                ];
                foreach ($renderBooking->OrderBooking as $orderBooking) {
                    if (null !== $filter_status && $orderBooking->status != $filter_status) {
                        continue;
                    }
                    $orderBooking->time_start = $renderBooking->day . ' ' . $renderBooking->time_start;
                    $orderBooking->department = $department;
                    $orderBooking->stylist = $this->user
                        ->find($orderBooking->stylist_id, ['name', 'email', 'phone']);

                    $dataBooks[] = $orderBooking;
                }
            }
            $data['list_book'] = $dataBooks;
            $responseData[] = $data;

            $currentDate->addDay(1);
        }
        $response['data'] = $responseData;

        return Response::json($response, $response['status']);
    }

    public function filterBooking_backup(Request $request)
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
                $startDate = $date_start->format('Y-m-d H:i:s');
                $endDate = $date_end->endOfDay();
                break;
        }

        $filter_status = $request->status; //cancel - finished - pending
        $perPage = (int) $request->per_page ?: config('model.booking.default_filter_limit');
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
        if(!$booking) {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __("There's no booking with this phone!");

            return Response::json($response, $response['status']);
        }        

        $booking->render_booking = $this->renderBooking->find($booking->render_booking_id);
        $booking->department = $this->department->find($booking->render_booking->department_id);
        $booking->stylist = $this->user->find($booking->stylist_id);

        $response['data'] = $booking;

        return Response::json($response);
    }

    public function changeStatus(Request $request, $id)
    {
        $response = Helper::apiFormat();

        $user = Auth::guard('api')->user();
        if (!$user || $user->permission != User::PERMISSION_ADMIN) {
            $response['error'] = true;
            $response['message'][] = __('You do not have permission to perform this action!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $orderBooking = $this->orderBooking->find($id);

        if (!$orderBooking) {
            $response['error'] = true;
            $response['status'] = 404;
            $response['message'][] = __('Not found this booking ordered!');

            return Response::json($response);
        }

        $rule = [
            'status' => 'numeric',
        ];
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, $response['status']);
        }

        $dataEdit = [
            'status' =>$request->status,
        ];
        if($dataEdit['status'] > 3 || $dataEdit['status'] < 0)
        {
            $dataEdit['status'] = 1;
        }
        try {
            $orderBooking->fill($dataEdit)->save();
            $response['message'][] = __('Updated Status booking successfully!');
        } catch (Exception $e) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = $e->getMessage();
        }

        return Response::json($response, $response['status']);
    }

    public function getBookingbyId($bookingId)
    {
        $response = Helper::apiFormat();

        $booking = $this->orderBooking->getBookingByBookingId($bookingId);

        if (!$booking)
        {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __('404 not found');
            return Response::json($response, $response['status']);
        }
        
        $renderBooking = $this->renderBooking->find($booking->render_booking_id);
        $booking->render_booking = $renderBooking;
        $booking->department = $this->department->find($renderBooking->department_id);
        $booking->stylist =  $this->user->find($booking->stylist_id);
        
        $response['data'] = $booking;
        
        return Response::json($response, $response['status']);
    }
}


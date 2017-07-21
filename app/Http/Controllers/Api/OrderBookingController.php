<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\OrderBookingRepository;
use App\Contracts\Repositories\RenderBookingRepository;
use App\Contracts\Repositories\UserRepository;
use App\Helpers\Helper;
use App\Eloquents\OrderBooking;
use Validator;
use Auth;
use Response;

class OrderBookingController extends Controller
{
    protected $OrderBooking, $RenderBooking, $user;

    public function __construct( 
        OrderBookingRepository $OrderBooking, 
        RenderBookingRepository $RenderBooking,
        UserRepository $user
    ) {
        $this->OrderBooking = $OrderBooking;
        $this->RenderBooking = $RenderBooking;
        $this->user = $user;
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

        return Response::json($booking);
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
        if (!$stylist_id) {
            $renderBooking = $this->RenderBooking
                ->find($request->render_booking_id, ['OrderBooking']);

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

                $response['data'] = $this->OrderBooking->find($bookingChecked->id);

            } else {
                $data = [
                    'render_booking_id' => $request->render_booking_id,
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'stylist_id' => $stylist_id,
                    'user_id' => $user_id,
                ];
                $order = $this->OrderBooking->create($data);

                $response['data'] = $this->OrderBooking->find($order->id);
            }
        } else {
            $order = $this->OrderBooking->create([
                'render_booking_id' => $request->render_booking_id,
                'phone' => $request->phone,
                'name' => $request->name,
                'stylist_id' => $stylist_id,
                'user_id' => $user_id,
            ]);

            $response['data'] = $this->OrderBooking->find($order->id);
        }

        return Response::json($response, $response['status']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\OrderBookingRepository;
use App\Helpers\Helper;
use Response;

class OrderBookingController extends Controller
{
    protected $OrderBooking;

    public function __construct( OrderBookingRepository $OrderBooking) {
        $this->OrderBooking = $OrderBooking;
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
}

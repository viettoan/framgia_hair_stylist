<?php
namespace App\Eloquents\Relations;

use App\Eloquents\LogStatus;
use App\Eloquents\OrderBooking;
use App\Eloquents\User;

trait LogStatusRelations
{
    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class, 'order_booking_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

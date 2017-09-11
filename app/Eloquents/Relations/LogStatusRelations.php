<?php
namespace App\Eloquents\Relations;

use App\Eloquents\LogStatus;
use App\Eloquents\OrderBooking;
use App\Eloquents\User;

trait LogStatusRelations
{
    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class);
    }

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }
}

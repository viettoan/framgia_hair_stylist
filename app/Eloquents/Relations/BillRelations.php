<?php

namespace App\Eloquents\Relations;

use App\Eloquents\BillItem;
use App\Eloquents\User;
use App\Eloquents\OrderBooking;

trait BillRelations
{
    public function BillItems()
    {
        return $this->hasMany(BillItem::class, 'bill_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class, 'order_booking_id');
    }
}

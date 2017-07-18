<?php

namespace App\Eloquents\Relations;

use App\Eloquents\User;
use App\Eloquents\RenderBooking;
use App\Eloquents\OrderItem;

trait OrderBookingRelations
{
    public function getUser()
    {
        return $this->belongsTo(User::class);
    }

    public function getBookingRender()
    {
        return $this->belongsTo(RenderBooking::class, 'render_booking_id');
    }
    public function getOrderItem()
    {
        return $this->hasOne(OrderItem::class, 'order_id');
    }
}

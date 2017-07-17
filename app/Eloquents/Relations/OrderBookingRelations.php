<?php

namespace App\Eloquent\Relations;

use App\Eloquent\User;
use App\Eloquent\RenderBooking;
use App\Eloquent\OrderItem;

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

<?php

namespace App\Eloquents\Relations;

use App\Eloquents\Department;
use App\Eloquents\OrderBooking;

trait RenderBookingRelations
{
    public function Department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    public function OrderBooking()
    {
        return $this->hasMany(OrderBooking::class, 'render_booking_id');
    }
}

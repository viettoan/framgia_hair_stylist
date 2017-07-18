<?php

namespace App\Eloquents\Relations;

use App\Eloquents\Department;
use App\Eloquents\OrderBooking;

trait RenderBookingRelations
{
    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    public function getOrderBooking()
    {
    	return $this->hasMany(OrderBooking::class, 'render_booking_id')
    }
}

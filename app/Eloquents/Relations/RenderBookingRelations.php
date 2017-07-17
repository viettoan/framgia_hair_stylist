<?php

namespace App\Eloquent\Relations;

use App\Eloquent\Department;
use App\Eloquent\OrderBooking;

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

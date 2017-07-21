<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\OrderBookingRelations;

class OrderBooking extends Model
{
    use OrderBookingRelations;

    protected $fillable = [
        'render_booking_id',
        'user_id',
        'phone',
        'name',
        'stylist_id',
        'grand_total',
    ];

    public function setStatusAttribute($value)
    {
    	if (!$value) {
    		$this->attributes['status'] = 1;
    	}
    }
}

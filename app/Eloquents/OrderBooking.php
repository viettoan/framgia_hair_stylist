<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class OrderBooking extends Model
{
    use OrderBookingRelations;

    protected $fillable = [
        'id',
        'render_booking_id',
        'user_id',
        'phone',
        'name',
        'stylist_id',
        'grand_total',
    ];
}

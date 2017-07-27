<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\OrderBookingRelations;

class OrderBooking extends Model
{
    use OrderBookingRelations;

    const STATUS_NONE = 0;
    const STATUS_DONE= 1;
    const STATUS_CANCEL = 2;

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

    public static function getOptionStatus()
    {
        return [
            self::STATUS_NONE => __('None'),
            self::STATUS_DONE => __('Done'),
            self::STATUS_CANCEL => __('Cancel'),
        ];
    }
}

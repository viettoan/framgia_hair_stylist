<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\OrderBookingRelations;

class OrderBooking extends Model
{
    use OrderBookingRelations;

    const STATUS_CANCEL = 0;
    const STATUS_PENDING = 1;
    const STATUS_FINISHED = 2;


    protected $fillable = [
        'render_booking_id',
        'user_id',
        'phone',
        'name',
        'stylist_id',
        'grand_total',
        'status'
    ];

    public function setStatusAttribute($value)
    {
        if (!$value) {
            $this->attributes['status'] = 1;
        } else {
            $this->attributes['status'] = $value;
        }
    }

    public static function getOptionStatus()
    {
        return [
            self::STATUS_CANCELED => __('Canceled'),
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_FINISHED => __('Finished'),
        ];
    }
}

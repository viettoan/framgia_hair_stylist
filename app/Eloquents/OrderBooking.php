<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\OrderBookingRelations;

class OrderBooking extends Model
{
    use OrderBookingRelations;
    // status booking
    const STATUS_NONE = 0;
    const STATUS_DONE= 1;
    const STATUS_CANCEL = 2;
    // filter type
    const FILTER_NONE = 0;
    const FILTER_DAY = 1;
    const FILTER_MONTH = 2;
    const FILTER_WEEK = 3;
    const FILTER_STATUS = 4;

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

    public static function getOptionFilter()
    {
        return [
            self::FILTER_NONE => __('None'),
            self::FILTER_DAY => __('Day'),
            self::FILTER_MONTH => __('Month'),
            self::FILTER_WEEK => __('Week'),
            self::FILTER_STATUS => __('Status'),
        ];
    }
}

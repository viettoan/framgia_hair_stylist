<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\BillRelations;

class Bill extends Model
{
    use BillRelations;

    const STATUS_PENDING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_CANCEL = 2;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone',
        'order_booking_id',
        'status',
        'grand_total',
        'service_total',
    ];
}

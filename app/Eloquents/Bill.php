<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\BillRelations;

class Bill extends Model
{
    use BillRelations;

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

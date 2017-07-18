<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\RenderBookingRelations;

class RenderBooking extends Model
{
    use RenderBookingRelations;

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    protected $fillable = [
        'day',
        'time_start',
        'total_slot',
        'status',
        'department_id',
    ];
}

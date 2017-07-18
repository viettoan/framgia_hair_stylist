<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\RenderBookingRelations;

class RenderBooking extends Model
{
    use RenderBookingRelations;

    protected $fillable = [
        'day',
        'time_start',
        'total_slot',
        'status',
        'department_id',
    ];
}

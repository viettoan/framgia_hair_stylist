<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class RenderBooking extends Model
{
    use RenderBookingRelations;

    protected $fillable = [
        'id',
        'day',
        'time_start',
        'total_slot',
        'status',
        'department_id',
    ];
}

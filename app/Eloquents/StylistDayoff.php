<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\StylistDayoffRelations;

class StylistDayoff extends Model
{
    use StylistDayoffRelations;

    protected $fillable = [
        'stylist_id',
        'day',
        'time',
        'status',
        'content',
    ];
}

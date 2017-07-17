<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class StylistDayoff extends Model
{
    use StylistDayoffRelations;

    protected $fillable = [
        'id',
        'stylist_id',
        'day',
        'time',
        'status',
        'content',
    ];
}

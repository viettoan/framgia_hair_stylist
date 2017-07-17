<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class TimeSheetStylist extends Model
{
    use TimeSheetStylistRelations;

    protected $fillable = [
        'id',
        'stylist_id',
        'mon',
        'tues',
        'wed',
        'thur',
        'fri',
        'sat',
        'sun',
    ];
}

<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\TimeSheetStylistRelations;

class TimeSheetStylist extends Model
{
    use TimeSheetStylistRelations;

    protected $fillable = [
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

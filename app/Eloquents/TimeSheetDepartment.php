<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class TimeSheetDepartment extends Model
{

    const ON_WORK = 1;
    const OFF_WORK = 0;

    protected $fillable = [
        'mon',
        'tues',
        'wed',
        'thur',
        'fri',
        'sat',
        'sun',
    ];
}

<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class TimeSheetDepartment extends Model
{
    protected $fillable = [
        'id',
        'mon',
        'tues',
        'wed',
        'thur',
        'fri',
        'sat',
        'sun',
    ];
}

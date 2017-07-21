<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\DepartmentDayoffRelations;

class DepartmentDayoff extends Model
{
    use DepartmentDayoffRelations;

    const OFF_WORK = 'off';
    const ON_WORK = 'on';

    protected $fillable = [
        'title',
        'day',
        'time',
        'department_id',
    ];
}

<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\DepartmentDayoffRelations;

class DepartmentDayoff extends Model
{
    use DepartmentDayoffRelations;

    protected $fillable = [
        'title',
        'day',
        'time',
        'department_id',
    ];
}

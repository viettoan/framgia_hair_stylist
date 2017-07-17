<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class DepartmentDayoff extends Model
{
    use DepartmentDayoffRelations;

    protected $fillable = [
        'id',
        'title',
        'day',
        'time',
        'department_id',
    ];
}

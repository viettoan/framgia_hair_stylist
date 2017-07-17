<?php

namespace App\Eloquent\Relations;

use App\Eloquent\Department;

trait DepartmentDayoffRelations
{
    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

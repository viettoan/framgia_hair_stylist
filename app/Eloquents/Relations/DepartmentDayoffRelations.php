<?php

namespace App\Eloquents\Relations;

use App\Eloquents\Department;

trait DepartmentDayoffRelations
{
    public function getDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

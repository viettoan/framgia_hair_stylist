<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepartmentDayoffRepository;
use App\Eloquents\DepartmentDayoff;

class DepartmentDayoffRepositoryEloquent extends AbstractRepositoryEloquent implements DepartmentDayoffRepository
{
    public function model()
    {
        return new DepartmentDayoff;
    }

    public function getDayoffByDepartment($department_id)
    {
        return $this->model()->where('department_id', $department_id)->get();
    }
}

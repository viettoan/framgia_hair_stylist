<?php

namespace App\Contracts\Repositories;

interface DepartmentDayoffRepository extends AbstractRepository
{
    public function getDayoffByDepartment($department_id);
}

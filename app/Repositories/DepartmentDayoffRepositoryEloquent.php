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
}

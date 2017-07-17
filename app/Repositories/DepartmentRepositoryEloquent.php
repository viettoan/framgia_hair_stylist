<?php

namespace App\Repositories;

use App\Contracts\Repositories\DepartmentRepository;
use App\Eloquents\Department;

class DepartmentRepositoryEloquent extends AbstractRepositoryEloquent implements DepartmentRepository
{
    public function model()
    {
        return new Department;
    }
}

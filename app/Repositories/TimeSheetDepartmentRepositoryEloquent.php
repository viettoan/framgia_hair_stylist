<?php

namespace App\Repositories;

use App\Contracts\Repositories\TimeSheetDepartmentRepository;
use App\Eloquents\TimeSheetDepartment;

class TimeSheetDepartmentRepositoryEloquent extends AbstractRepositoryEloquent implements TimeSheetDepartmentRepository
{
    public function model()
    {
        return new TimeSheetDepartment;
    }
}

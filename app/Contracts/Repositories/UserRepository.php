<?php

namespace App\Contracts\Repositories;

interface UserRepository extends AbstractRepository
{
    public function getStylistByDepartmentId($departmentId, $select = ['*'], $with = []);
}

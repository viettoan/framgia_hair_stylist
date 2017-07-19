<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository;
use App\Eloquents\User;

class UserRepositoryEloquent extends AbstractRepositoryEloquent implements UserRepository
{
    public function model()
    {
        return new User;
    }

    public function getStylistByDepartmentId($departmentId, $select = ['*'], $with = [])
    {
        $data = $this->model()->select($select)->with($with)
            ->where('department_id', $departmentId)
            ->where('permission', User::PERMISSION_MAIN_WORKER)->get();

        return $data;
    }
}

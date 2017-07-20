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

    public function create($data)
    {
        $user = $this->model()->fill($data);
        $user->save();

        return $user;
    }

    public function findByEmailOrPhone($value)
    {
        return $this->model()->orWhere('email', $value)->orWhere('phone', $value)->first();
    }

    public function existEmailOrPhone($email, $phone)
    {
        $userEmail = $this->model()->where('email', $email)->first();
        $userPhone = $this->model()->where('phone', $phone)->first();

        return ($userEmail || $userPhone) ? true : false;
    }
}

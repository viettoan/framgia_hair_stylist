<?php

namespace App\Contracts\Repositories;

interface UserRepository extends AbstractRepository
{
    public function getStylistByDepartmentId($departmentId, $select = ['*'], $with = []);
    public function create($data);
    public function findByEmailOrPhone($value);
    public function existEmailOrPhone($email, $phone);
}

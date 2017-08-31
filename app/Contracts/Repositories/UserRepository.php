<?php

namespace App\Contracts\Repositories;

interface UserRepository extends AbstractRepository
{
    public function getStylistByDepartmentId($departmentId, $select = ['*'], $with = []);

    public function create($data);

    public function findByEmailOrPhone($value);

    public function existEmailOrPhone($email, $phone);

    public function find($id, $select = ['*'], $with = []);

    public function getAllCustommer($per_page, $with = [], $select = ['*']);

    public function getAllCustomerExceptAdmin($per_page, $with = [], $select = ['*']);

    public function findByPhone($phone);

    public function filterCustomer($keyword, $per_page, $with = [], $select = ['*']);
}

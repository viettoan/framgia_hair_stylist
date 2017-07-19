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

    public function getAllData($with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->with($with)->get();
    }

    public function find($id ,$with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->with($with)->find($id);
    }
}

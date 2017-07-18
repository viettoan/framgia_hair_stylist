<?php

namespace App\Contracts\Repositories;

interface DepartmentRepository extends AbstractRepository
{
	public function getAllData($with = [], $select = ['*']);
}

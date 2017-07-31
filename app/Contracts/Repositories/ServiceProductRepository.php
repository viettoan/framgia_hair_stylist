<?php

namespace App\Contracts\Repositories;

interface ServiceProductRepository extends AbstractRepository
{
    public function create($data);

    public function find($id, $with = [], $select = ['*']);

    public function getAllService($with = [], $select = ['*']);
}

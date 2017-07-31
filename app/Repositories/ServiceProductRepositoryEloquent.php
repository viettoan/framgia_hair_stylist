<?php

namespace App\Repositories;

use App\Contracts\Repositories\ServiceProductRepository;
use App\Eloquents\ServiceProduct;

class ServiceProductRepositoryEloquent extends AbstractRepositoryEloquent implements ServiceProductRepository
{
    public function model()
    {
        return new ServiceProduct;
    }

    public function create($data)
    {
    	return $this->model()->create($data);
    }

    public function find($id, $with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->with($with)->find($id);
    }

    public function getAllService($with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->get();
    }
}

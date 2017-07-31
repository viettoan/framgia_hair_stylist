<?php

namespace App\Repositories;

use App\Contracts\Repositories\BillRepository;
use App\Eloquents\Bill;

class BillRepositoryEloquent extends AbstractRepositoryEloquent implements BillRepository
{
    public function model()
    {
        return new Bill;
    }
    
    public function getBillByCustomerId($customerId, $perPage, $with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->where('customer_id', $customerId)->with($with)->paginate($perPage);
    }
}

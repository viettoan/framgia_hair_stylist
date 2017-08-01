<?php

namespace App\Repositories;

use App\Contracts\Repositories\BillItemRepository;
use App\Eloquents\BillItem;

class BillItemRepositoryEloquent extends AbstractRepositoryEloquent implements BillItemRepository
{
    public function model()
    {
        return new BillItem;
    }

    public function create($data)
    {
        return $this->model()->create($data);
    }
}

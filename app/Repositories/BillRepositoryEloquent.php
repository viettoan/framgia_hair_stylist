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
}

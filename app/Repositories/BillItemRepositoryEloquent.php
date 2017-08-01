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

    public function find($id, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->find($id);
    }

    public function getItemsByBillId($bill_id, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->where('bill_id', $bill_id)->get();
    }
}

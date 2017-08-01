<?php

namespace App\Contracts\Repositories;

interface BillItemRepository extends AbstractRepository
{
    public function create($data);

    public function find($id, $with = [], $select = ['*']);

    public function getItemsByBillId($bill_id, $with = [], $select = ['*']);
}

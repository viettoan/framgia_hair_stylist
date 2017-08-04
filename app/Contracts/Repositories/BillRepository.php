<?php

namespace App\Contracts\Repositories;

interface BillRepository extends AbstractRepository
{
    public function getBillByCustomerId($customerId, $perPage, $with = [], $select = ['*']);
    
    public function create($data);

    public function find($id, $with = [], $select = ['*']);

    public function getBillByYear($year, $status, $select = ['*'], $with = []);

    public function getBillByMonth($month, $year, $status, $select = ['*'], $with = []);

    public function getBillByDate($date, $status, $select = ['*'], $with = []);
}

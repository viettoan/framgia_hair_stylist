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

    public function getGroupBillByYear($year, $select = ['*'], $with = []);

    public function getGroupBillByMonth($month, $year, $select = ['*'], $with = []);

    public function getGroupBillByDate($date, $select = ['*'], $with = []);

    public function countBillByPhone($phone);

    public function getFilterBillByDate($date, $filter, $select = ['*'], $with = []);

    public function getBillByCustomerIdWithImage($customerId, $billId, $with = [], $select = ['*']);
}

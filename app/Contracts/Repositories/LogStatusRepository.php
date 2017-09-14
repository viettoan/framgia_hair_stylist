<?php

namespace App\Contracts\Repositories;

interface LogStatusRepository extends AbstractRepository
{
    public function create($data);

    /**
     * Get Log Status by Order Booking Id
     */
    public function getLogStatus($id , $with = [], $select = ['*']);
}

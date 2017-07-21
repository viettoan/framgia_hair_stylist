<?php

namespace App\Contracts\Repositories;

interface OrderBookingRepository extends AbstractRepository
{
    public function getBookingByBookingId($bookingId, $with = []);

    public function create($data = []);

    public function checkLastBookingByPhone($with = [], $select = ['*'], $value);

    public function find($id, $with = [], $select = ['*']);
}

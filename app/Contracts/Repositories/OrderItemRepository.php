<?php

namespace App\Contracts\Repositories;

interface OrderItemRepository extends AbstractRepository
{
    public function create($data);

    public function find($id, $with = [], $select = ['*']);

    public function getItemsByBookingId($order_id, $with = [], $select = ['*']);
}

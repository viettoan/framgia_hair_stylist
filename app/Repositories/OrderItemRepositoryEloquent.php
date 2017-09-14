<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderItemRepository;
use App\Eloquents\OrderItem;

class OrderItemRepositoryEloquent extends AbstractRepositoryEloquent implements OrderItemRepository
{
    public function model()
    {
        return new OrderItem;
    }

    public function create($data)
    {
        return $this->model()->create($data);
    }

    public function find($id, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->find($id);
    }

    public function getItemsByBookingId($order_booking_id, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->where('order_booking_id', $order_booking_id)->get();
    }
}

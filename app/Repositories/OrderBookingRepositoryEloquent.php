<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderBookingRepository;
use App\Eloquents\OrderBooking;

class OrderBookingRepositoryEloquent extends AbstractRepositoryEloquent implements OrderBookingRepository
{
    public function model()
    {
        return new OrderBooking;
    }

    public function getBookingByBookingId($bookingId, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->find($bookingId);
    }
}

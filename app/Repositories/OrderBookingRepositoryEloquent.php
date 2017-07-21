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

    public function create($data = [])
    {
        $order = $this->model()->fill($data);
        $order->save();

        return $order;
    }
    
    public function getBookingByBookingId($bookingId, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->find($bookingId);
    }

    public function checkLastBookingByPhone($value, $with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->with($with)->where('phone', $value)->orderBy('id','desc')->first();
    }

    public function find($id, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->find($id);
    }

}

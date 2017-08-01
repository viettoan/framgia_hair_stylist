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

    public function filterBookingbyDate($startDate, $endDate, $perPage, $with = [], $select = ['*'])
    {
        
        return $this->model()->select($select)->with($with)->whereBetween('created_at', array($startDate, $endDate))->paginate($perPage);
    }

    public function filterBookingByStatus($status, $perPage, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->where('status', $status)->paginate($perPage);
    }
    
    public function getAllBooking($perPage, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->paginate($perPage);
    }

    public function filterBookingByMonth($month, $year, $perPage, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->whereMonth('created_at', $month)->whereYear('created_at', $year)->paginate($perPage);
    }

    public function getFilterChoice()
    {
        return $this->model()->getOptionFilter();
    }

    public function getBookingByCustomerId($customer_id, $with = [], $select = ['*'])
    {
        return $this->model()
            ->select($select)
            ->with($with)
            ->where('user_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}

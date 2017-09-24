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

    public function filterBookingbyDate($startDate, $endDate, $status, $with = [], $select = ['*'])
    {
        $query =  $this->model()->select($select)->with($with)
            ->whereBetween('updated_at', array($startDate, $endDate));

        if (null !== $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }

    public function filterBookingByStatus($status, $perPage, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->where('status', $status)->paginate($perPage);
    }
    
    public function getAllBooking($perPage, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->paginate($perPage);
    }

    public function filterBookingByMonth($month, $year, $perPage, $status, $with = [], $select = ['*'])
    {
        $query = $this->model()->select($select)->with($with)->whereMonth('created_at', $month)->whereYear('created_at', $year);
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->paginate($perPage);
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
    
    public function getBookingByStatus($status, $with = [], $select = ['*'])
    {
        return $this->model()
            ->select($select)
            ->with($with)
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getBookingByYear($year, $status, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)->whereYear('updated_at', $year);
        if (null != $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }

    public function getBookingByMonth($month, $year, $status, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)
        ->whereYear('updated_at', $year)->whereMonth('updated_at', $month);
        if (null != $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }

    public function getBookingByDate($date, $status, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)->whereDate('updated_at', $date);
        if (null != $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\LogStatusRepository;
use App\Eloquents\LogStatus;

class LogStatusRepositoryEloquent extends AbstractRepositoryEloquent implements LogStatusRepository
{
    public function model()
    {
        return new LogStatus;
    }

    public function create($data)
    {
        return $this->model()->create($data);
    }

    /**
     * Get Log Status by Order Booking Id
     */
    public function getLogStatus($order_booking_id , $with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->with($with)
    		->where('order_booking_id', $order_booking_id)
    		->get();
    }
}

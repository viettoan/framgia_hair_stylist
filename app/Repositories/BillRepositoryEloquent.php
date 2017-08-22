<?php

namespace App\Repositories;

use App\Contracts\Repositories\BillRepository;
use App\Eloquents\Bill;

class BillRepositoryEloquent extends AbstractRepositoryEloquent implements BillRepository
{
    public function model()
    {
        return new Bill;
    }
    
    public function getBillByCustomerId($customerId, $perPage, $with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->where('customer_id', $customerId)->with($with)->paginate($perPage);
    }

    public function create($data)
    {
        $bill = $this->model()->fill($data);
        $bill->save();

        return $bill;
    }

    public function find($id, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)->find($id);
    }

    public function getBillByYear($year, $status, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)->whereYear('updated_at', $year);
        if (null != $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }

    public function getBillByMonth($month, $year, $status, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)
            ->whereYear('updated_at', $year)->whereMonth('updated_at', $month);
        if (null != $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }

    public function getBillByDate($date, $status, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)->whereDate('updated_at', $date);
        if (null != $status) {
            $query->where('status', $status);
        }
        
        return $query->get();
    }

    public function getGroupBillByYear($year, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)
            ->whereYear('updated_at', $year)->groupBy('phone');
        
        return $query->get();
    }

    public function getGroupBillByMonth($month, $year, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)
            ->whereYear('updated_at', $year)
            ->whereMonth('updated_at', $month)
            ->groupBy('phone');
        
        return $query->get();
    }

    public function getGroupBillByDate($date, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)
            ->whereDate('updated_at', $date)->groupBy('phone');
        
        return $query->get();
    }

    public function countBillByPhone($phone)
    {
        return $this->model()->where('phone', $phone)->count();
    }

    public function getFilterBillByDate($date, $filter, $select = ['*'], $with = [])
    {
        $query = $this->model()->select($select)->with($with)->whereDate('updated_at', $date);

        if (isset($filter['status']) && null !== $filter['status']) {
            $query->whereIn('status', $filter['status']);
        }
        if (isset($filter['department_id']) && null !== $filter['department_id']) {
            $query->where('department_id', $filter['department_id']);
        }
        if (isset($filter['customer_id']) && null !== $filter['customer_id']) {
            $query->where('customer_id', $filter['customer_id']);
        }
        
        return $query->get();
    }

    public function getBillByCustomerIdWithImage($customerId, $billId, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->where('customer_id', $customerId)->with($with)->get();
    }
}

<?php

namespace App\Repositories;

use App\Contracts\Repositories\RenderBookingRepository;
use App\Eloquents\RenderBooking;

class RenderBookingRepositoryEloquent extends AbstractRepositoryEloquent implements RenderBookingRepository
{
    public function model()
    {
        return new RenderBooking;
    }

    public function create($data = [])
    {
        return $this->model()->create($data);
    }

    public function find($id, $with = [], $select = ['*'])
    {
    	return $this->model()->select($select)->with($with)->find($id);
    }

    public function getRenderDepartment($department_id, $day, $with = [], $select = ['*'])
    {
        return $this->model()->select($select)->with($with)
            ->where('department_id', $department_id)
            ->where('day', $day)->get();
    }

    public function getRenderByDate($date, $department_id, $with = [], $select = ['*'])
    {
        $query = $this->model()->select($select)->with($with)->where('day', $date);

        if (null !== $department_id) {
            $query->where('department_id', $department_id);
        }

        return $query->get();
    }
}

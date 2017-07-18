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
        $this->model()->create($data);
    }
}

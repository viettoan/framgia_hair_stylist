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
}

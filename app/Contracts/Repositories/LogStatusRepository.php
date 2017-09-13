<?php

namespace App\Contracts\Repositories;

interface LogStatusRepository extends AbstractRepository
{
    public function create($data);
}

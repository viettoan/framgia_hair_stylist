<?php

namespace App\Contracts\Repositories;

interface BillItemRepository extends AbstractRepository
{
    public function create($data);
}

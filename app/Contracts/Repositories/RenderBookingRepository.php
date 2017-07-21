<?php

namespace App\Contracts\Repositories;

interface RenderBookingRepository extends AbstractRepository
{
    public function create($data = []);

    public function find($id, $with = [], $select = ['*']);

    public function getRenderDepartment($deparment_id, $day, $with = [], $select = ['*']);
}

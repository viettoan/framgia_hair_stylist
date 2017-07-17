<?php

namespace App\Eloquent\Relations;

use App\Eloquent\User;
use App\Eloquent\DepartmentDayoff;
use App\Eloquent\RenderBooking;

trait DepartmentRelations
{
    public function getStylistByDepartment()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function getDepartmentDayoff()
    {
        return $this->hasMany(DepartmentDayoff::class, 'department_id');
    }

    public function getBookingRender()
    {
        return $this->hasMany(RenderBooking::class, 'department_id');
    }
}

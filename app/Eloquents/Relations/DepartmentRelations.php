<?php

namespace App\Eloquents\Relations;

use App\Eloquents\User;
use App\Eloquents\DepartmentDayoff;
use App\Eloquents\RenderBooking;

trait DepartmentRelations
{
    public function StylistByDepartment()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function DepartmentDayoff()
    {
        return $this->hasMany(DepartmentDayoff::class, 'department_id');
    }

    public function BookingRender()
    {
        return $this->hasMany(RenderBooking::class, 'department_id');
    }
}

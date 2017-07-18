<?php

namespace App\Eloquents\Relations;

use App\Eloquents\TimeSheetStylist;
use App\Eloquents\StylistDayoff;
use App\Eloquents\OrderBooking;
use App\Eloquents\Department;

trait UserRelations
{
    public function getTimeSheetStylist()
    {
        return $this->hasOne(TimeSheetStylist::class, 'stylist_id');
    }

    public function getStylistDayoff()
    {
        return $this->hasOne(StylistDayoff::class, 'stylist_id');
    }

    public function getOrderBooking()
    {
        return $this->hasOne(OrderBooking::class);
    }

    public function getStylistInDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

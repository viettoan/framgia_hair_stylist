<?php

namespace App\Eloquent\Relations;

use App\Eloquent\TimeSheetStylist;
use App\Eloquent\StylistDayoff;
use App\Eloquent\OrderBooking;
use App\Eloquent\Department;

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

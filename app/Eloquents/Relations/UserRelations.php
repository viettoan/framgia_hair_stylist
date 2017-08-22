<?php

namespace App\Eloquents\Relations;

use App\Eloquents\TimeSheetStylist;
use App\Eloquents\StylistDayoff;
use App\Eloquents\OrderBooking;
use App\Eloquents\Department;
use App\Eloquents\Bill;
use App\Eloquents\BillItem;

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
        return $this->hasMany(OrderBooking::class, 'user_id');
    }

    public function OrderBookings()
    {
        return $this->hasMany(OrderBooking::class);
    }

    public function getStylistInDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getAllBill()
    {
        return $this->hasMany(Bill::class, 'customer_id');
    }

    public function getBillItem()
    {
        return $this->hasMany(BillItem::class, 'stylist_id');
    }
}

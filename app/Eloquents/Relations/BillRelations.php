<?php

namespace App\Eloquents\Relations;

use App\Eloquents\BillItem;
use App\Eloquents\User;
use App\Eloquents\OrderBooking;
use App\Eloquents\Department;
use App\Eloquents\Media;

trait BillRelations
{
    public function getAllBillItems()
    {
        return $this->hasMany(BillItem::class, 'bill_id');
    }

    public function BillItems()
    {
        return $this->hasMany(BillItem::class, 'bill_id');
    }

    public function Department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class, 'order_booking_id');
    }
    
    public function Images()
    {
        return $this->morphMany(Media::class, 'media_table');
    }
}

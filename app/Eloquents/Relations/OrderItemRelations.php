<?php

namespace App\Eloquent\Relations;

use App\Eloquent\OrderBooking;
use App\Eloquent\ServiceProduct;

trait DepartmentDayoffRelations
{
    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class, 'order_id');
    }
    
    public function getServiceProduct()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    }
}
